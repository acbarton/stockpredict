

import sys
sys.path.insert(0, '../CNN')
import load_data

import numpy as np
import matplotlib.pyplot as plt
import matplotlib.dates as mdates

from datetime import datetime


def load_titles(article_titles):
    
    with open("../ParseArticles/train_titles.txt", 'rb') as f:
        lines = f.readlines()
        
        for i in range(0, len(lines)):
            line = lines[i]
            #parts = line.strip().split('\n')
            
            article_titles.append(line)
            #print line
            
def SMA(closing_SMA):
    
    with open("../ParseArticles/technical_indicator_XOM.csv", 'rb') as f:
        lines = f.readlines()
        
        for i in range(1, len(lines)):
            line = lines[i]
            parts = line.strip().split(',')
            #print parts
            closing_SMA.append(float(parts[1]))
            
def load_prices(closing_prices,closing_dates):
    
    with open("../ParseArticles/daily_XOM_mod.csv", 'rb') as f:
        lines = f.readlines()
        
        for i in range(1, len(lines)):
            line = lines[i]
            parts = line.strip().split(',')
            #print parts
            date = datetime.strptime(parts[0], '%Y-%m-%d')
            closing_dates.append(date)
            closing_prices.append(float(parts[4]))
            
def annotate(closing_dates,closing_prices,article_titles,article_timestamps):
    
    xaxis=[]
    for x in range(0,len(closing_prices)):
        xaxis.append(x)
    count = 0
    for j in range(0,len(closing_dates)):
        #print j
        count += 1
        if count == 10:
            count = 0
            for z in xrange(0,len(article_timestamps)):
                
                if article_timestamps[z] == closing_dates[j]:
                    
                    if 'baytown' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    if 'getrichslow' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    if 'crane' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    if 'getrichslow' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    if 'siberia' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    if 'environmental' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    if 'sputter' in article_titles[z]:
                        plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                
                    
                    break
                elif article_timestamps[z] > closing_dates[j] and article_timestamps[z] < closing_dates[j+1] :
                   
                    plt.annotate(article_titles[z],xy=(xaxis[j],closing_prices[j]))
                    break
            
            
        

def main():
    
    closing_prices=[]
    closing_dates=[]
    load_prices(closing_prices,closing_dates)
    closing_prices.reverse()
    closing_dates.reverse()
    article_timestamps=[]
    load_data.load_article_timestamps(article_timestamps)
    
    article_titles=[]
    load_titles(article_titles)
    
    closing_SMA=[]
    SMA(closing_SMA)
    closing_SMA.reverse()
    

    plt.plot(closing_prices, lw=2)
    plt.plot(closing_SMA, lw=2)
  
    
    annotate(closing_dates,closing_prices,article_titles,article_timestamps)
   
    
    plt.show()
    
    
    

if __name__ == "__main__":
    main()
