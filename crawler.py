from bs4 import BeautifulSoup
import urllib2
import re
import logging
import csv

logger = logging.getLogger('crawling')
logger.setLevel(logging.DEBUG)
format = logging.Formatter("%(asctime)-15s - %(levelname)s - %(message)s")
ch = logging.FileHandler('crawling.log', mode = 'wb')
ch.setFormatter(format)
logger.addHandler(ch)

def getUrlList():
	req = urllib2.Request('https://en.wikipedia.org/wiki/United_States_presidential_election')
	response = urllib2.urlopen(req)
	the_page = response.read()
	urls = []

	soup = BeautifulSoup(the_page, 'lxml')
	for tag in soup.find_all('a'):
		if not tag.has_attr('href'): continue
		if re.match(r"/wiki/United_States_presidential_election,_[0-9]*", tag.get("href")):
			urls.append("https://en.wikipedia.org" + tag.get("href").split("%")[0])

	return list(set(urls))

def getTable(url):
	req = urllib2.Request(url)
	response = urllib2.urlopen(req)
	the_page = response.read()

	soup = BeautifulSoup(the_page, 'lxml')
	for tag in soup.find_all('table', {"class": "wikitable"}):
		if re.match(r"^Presidential candidate.*", tag.get_text().strip()):
			for line in tag.find_all('tr')[2:]:
				if line.find_all('td')[0].has_attr('colspan'): continue
				data = map(lambda x: re.sub(r"\(.*\)", "", x.text), line.find_all('td'))
				data = map(lambda x: re.sub(r"\[.*\]", "", x), data)
				if not data: continue
				# print line
				# print data
				people = set(map(lambda x: x.text, line.find_all('b')))

				presCand = data[0].encode('ascii', errors = 'ignore')

				if not presCand:
					logger.info('cannot identify candidate name %s'%data[0])
					continue

				if presCand.lower() == 'other' or presCand.lower() == "no candidate":
					continue

				# if not presCand in people:
				# 	# logger.error('cannot identify the candidate name (%s)'%presCand)
				# 	continue

				if len(data) < 6:
					logger.info("%s is likely a vice presidential candidate"%presCand)
					continue

				party = data[1].encode('ascii', errors = 'ignore')
				if not party:
					logger.info('cannot identify party %s'%data[1])
				if party == "None": party = None

				state = data[2].encode('ascii', errors = 'ignore')
				if not state:
					logger.info('cannot identify state %s'%data[2])

				try:
					count = int(data[3].replace(",", ""))
				except:
					count = None
					# logger.info('cannot identify the count %s for %s'%(data[3], presCand))


				try:
					percent = float(data[4].replace("%", ""))
				except:
					percent = None
					# logger.info('cannot identify the percent %s for %s'%(data[4], presCand))

				try:
					vote = int(data[5])
				except:
					vote = None
					# logger.info('cannot identify the vote %s for %s'%(data[5], presCand))

				yield (presCand, party, state, count, percent, vote)

	
def main():
	urls = getUrlList()
	logger.info('%d URLs found'%len(urls))

	results = []

	for url in urls:
		try:
			year = int(url[-4:])
			if year == 1789: continue
			logger.info('start parsing results for %d'%year)
		except:
			logger.error('Cannot find the year for URL %d'%url)

		for cand in getTable(url):
			results.append((year, ) + cand)

		# break

	# write results to CSV file
	results = sorted(results, key = lambda x: x[0])
	with open("results.csv", "wb") as f:
		writer = csv.writer(f)
		writer.writerows(results)


main()










