
import requests
#import pandas
import json
import re
from datetime import datetime
from datetime import timedelta
path='/var/www/html/scripts/python/TSLA/'
import sys

def getNewArticles():
    
    
    today = datetime.today()
    last = today - timedelta(days=30)
    last = str(last)[:10]
    
    
    datess = []
    text = []
    urls = []
    
    
    
    url = ('https://newsapi.org/v2/everything?'
        'sources=the-wall-street-journal&'
        'q=tesla&'
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
                arturl = v[i]['url']
                title = v[i]['title']
                #title = re.sub(r'[^a-zA-Z_0-9 ]', '', title)
                date = v[i]['publishedAt'][:10]
                date = datetime.strptime(date, '%Y-%m-%d')
                content = v[i]['content']
                #content = re.sub(r'[^a-zA-Z_0-9 ]', '', content)
                if 'Tesla' in title:
                    datess.append(date)
                    text.append(title)# + content + '\n')
                    urls.append(arturl)
    
    print   '<div class="sidebox">'
    print   '<h3>The Wall Street Journal</h3>'
    
    
    for i in range(0,len(text)):
        date = '{:%B %d, %Y}'.format(datess[i])
        try:
            print '<p>'+date+', <a href="'+urls[i]+'" target="_blank">' + str(text[i]) + '</a></p>'
        except:
            continue
        
    print   '</div>'
   



def main():

    
    getNewArticles()
    
 
 
if __name__ == "__main__":
    main()