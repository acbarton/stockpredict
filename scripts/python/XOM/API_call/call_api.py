
import requests
#import pandas
import json
import re
from datetime import datetime
from datetime import timedelta
path='/var/www/html/scripts/python/XOM/'
import sys
sys.path.insert(0, path+'CNN')
import load_data


def load_articles(articles):
    
    with open(path+"ParseArticles/train_articles.txt", 'rb') as f:
        lines = f.readlines()
        
        for i in range(0, len(lines)):
            line = lines[i]
            #parts = line.strip().split('\n')
            #print line
            articles.append(line)
    
    

def getNewArticles(article_timestamps,articles):
    
    
    today = datetime.today()
    last = today - timedelta(days=30)
    last = str(last)[:10]
    
    
    datess = []
    text = []
    
    
    
    url = ('https://newsapi.org/v2/everything?'
        'sources=the-wall-street-journal&'
        'q=exxon&'
        'from='+last+'&'
        'sortBy=publishedAt&'
        'apiKey=89c24ac2fff4411cb48bd06825c25450')
    response = requests.get(url)
    jsonObject = response.json()
    #print jsonObject
   
    for key in jsonObject:
        v = jsonObject[key]
        if key == 'articles':
            for i in range(0,len(v)):
                title = v[i]['title'].lower()
                title = re.sub(r'[^a-zA-Z_0-9 ]', '', title)
                date = v[i]['publishedAt'][:10]
                date = datetime.strptime(date, '%Y-%m-%d')
                content = v[i]['content'].lower()
                content = re.sub(r'[^a-zA-Z_0-9 ]', '', content)
                if 'exxon' in title:
                    datess.append(date)
                    text.append(title + content + '\n')
    
    
  
    for i in range(0,len(text)):
        if text[i] not in articles:
            
            f = open(path+'ParseArticles/train_articles.txt','a')
            f.write(text[i])
            f.close()
    
            f = open(path+'ParseArticles/article_timestamps.txt','a')
            f.write(str(datess[i]) + '\n')
            f.close()
    

def get_newPrices():
    
    url = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=XOM&apikey=XAPAO6Q6PIJ804G4&datatype=csv&outputsize=full'
    #response = requests.get(url)
    #jsonObject = response.json()
    #print jsonObject
    
    #for key in jsonObject:
        #if 'Time Series' in key:
            #line = jsonObject[key]
            #for lineKey in line:
                #print lineKey, line[lineKey]
    with requests.get(url, stream = True) as response:
        with open('test.csv', 'wb') as f:
            for chunk in response.iter_content(chunk_size = 1024):
                f.write(chunk)

def main():

    
    #article_timestamps=[]
    #load_data.load_article_timestamps(article_timestamps)
    #articles=[]
    #load_articles(articles)
    
    #getNewArticles(article_timestamps, articles)
    
    get_newPrices()
                    
              
            

if __name__ == "__main__":
    main()