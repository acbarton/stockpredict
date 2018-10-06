

# gensim modules
from gensim import utils
from gensim.models.doc2vec import LabeledSentence
from gensim.models import Doc2Vec

# numpy
import numpy as np
import matplotlib.pyplot as plt
import time
from PIL import Image

# shuffle
from random import shuffle

# logging
import logging
import os.path
import os
import sys
import cPickle as pickle

from sklearn.utils import shuffle
from sklearn.preprocessing import StandardScaler
from datetime import datetime
import theano
import theano.tensor as T

path='/var/www/html/scripts/python/TSLA/'

def load_article_timestamps(article_timestamps):
    
    with open(path+"ParseArticles/article_timestamps.txt", 'rb') as f:
        lines = f.readlines()
        
        for i in range(0, len(lines)):
            line = lines[i]
            parts = line.strip().split('\n')
            #time = parts[0]
            time = datetime.strptime(parts[0], '%Y-%m-%d %H:%M:%S')
            article_timestamps.append(time)
            
def load_prices(closing_prices,closing_dates):
    
    with open(path+"ParseArticles/daily_TSLA.csv", 'rb') as f:
        lines = f.readlines()
        
        for i in range(1, len(lines)):
            line = lines[i]
            parts = line.strip().split(',')
            #print parts
            date = datetime.strptime(parts[0], '%Y-%m-%d')
            closing_dates.append(date)
            closing_prices.append(float(parts[4]))
            
def printa(s,model):
    
    print 'Closest to '+ s +':'
    a = model.most_similar(s)
    for item in a:
        print item
        
def scale(a):
    scaler = StandardScaler()
    scaler.fit(a)
    a = scaler.transform(a)
    return a

def prices2image(stock_prices,id):
    
    plt.plot(stock_prices, lw=6)
    #plt.show()
    fig=plt.gcf()
    fig.savefig(path+'CNN/figs/fig.jpg', bbox_inches='tight',dpi=None, facecolor='w', edgecolor='w',
        orientation='portrait', papertype=None, format=None,
        transparent=False, pad_inches=0.1,
        frameon=None)
    #time.sleep(10)
    plt.clf()
    plt.close(fig)
    #plt.show()
    
    im = Image.open(path+'CNN/figs/fig.jpg')
    im = im.convert('L')
    im = im.resize((15, 15))
    a = np.array(im)
    a = a.reshape((225,))
    #print a.shape
    
    
    os.system('rm '+path+'CNN/figs/fig.jpg')
    return a

def label_data_all_dates(labels,closing_prices,closing_dates):
    PERCENT=0.0
    for j in range(382,len(closing_dates)-10):
        #print closing_prices[j]
        #print article_timestamps[i], closing_dates[j]
        if closing_prices[j+10] >= closing_prices[j]+(closing_prices[j]*PERCENT):
            labels.append(1)
        elif closing_prices[j+10] < (closing_prices[j])-(closing_prices[j]*PERCENT):
            labels.append(0)
        else:
            labels.append(2)
      
        
       
    
def label_data_news_dates(labels,closing_dates,closing_prices,article_timestamps,NUM_SAMPLES):
    PERCENT=0.0
    for i in range(0,NUM_SAMPLES):
        
        for j in range(0,len(closing_dates)):
            
            if article_timestamps[i] == closing_dates[j]:
                #print article_timestamps[i], closing_dates[j]
                if closing_prices[j+10] >= closing_prices[j]+(closing_prices[j]*PERCENT):
                    labels.append(1)
                elif closing_prices[j+10] < (closing_prices[j])-(closing_prices[j]*PERCENT):
                    labels.append(0)
                else:
                    labels.append(2)
                #print closing_prices[j], article_timestamps[i]
                break
            if article_timestamps[i] > closing_dates[j-1] and article_timestamps[i] < closing_dates[j]:
                #print article_timestamps[i], closing_dates[j]
                if closing_prices[j+10] >= closing_prices[j]+(closing_prices[j]*PERCENT):
                    labels.append(1)
                elif closing_prices[j+10] < (closing_prices[j])-(closing_prices[j]*PERCENT):
                    labels.append(0)
                else:
                    labels.append(2)
                #print closing_prices[j], article_timestamps[i]
                break
    
    
         
def load_data():
    
    
    article_timestamps=[]
    load_article_timestamps(article_timestamps)
    data=[]
    
    #printa('down',model)
    #printa('downturn',model)
    #printa('crisis',model)
    #printa('enthusiasm',model)
    #printa('revival',model)
    #printa('slump',model)
    #printa('looms',model)
    
    closing_prices=[]
    closing_dates=[]
    load_prices(closing_prices,closing_dates)
    closing_prices.reverse()
    closing_dates.reverse()
    
    #print "loading_data"
    with open(path+"CNN/figs/images_vecs_all_dates.pkl", "rb") as fp:   # Unpickling
        data = pickle.load(fp)
    
        
  
    labels=[]
    #label_data_news_dates(labels,closing_dates,closing_prices,article_timestamps,NUM_SAMPLES)
    label_data_all_dates(labels,closing_prices,closing_dates)
    NUM_SAMPLES = len(labels)
    
    
    
    data = np.array(data)
    #print data.shape
    #data.reshape((3994,100))
    data = scale(data)
    #print data
    #print labels [int(NUM_SAMPLES*.7):]
    labels = np.array(labels)
    
    #data,labels = shuffle(data,labels, random_state=0)
    train_data=data[:int(NUM_SAMPLES*.85)]
    train_labels=labels[:int(NUM_SAMPLES*.85)]
    train_data,train_labels = shuffle(train_data,train_labels, random_state=0)
    
    test_data=data[int(NUM_SAMPLES*.85):]
    test_labels=labels[int(NUM_SAMPLES*.85):]
    
    
    train_x=train_data#[:int(NUM_SAMPLES*.6)] 
    train_y=train_labels#[:int(NUM_SAMPLES*.6)]
    #valid_x=train_data[int(NUM_SAMPLES*.6):]
    #valid_y=train_labels[int(NUM_SAMPLES*.6):]
    valid_x = test_data
    valid_y = test_labels
    test_x=test_data
    test_y=test_labels
    
    #train_x,train_y = shuffle(train_x,train_y, random_state=0)
    
    
    #print labels.shape
    #print data.shape
    
    #print train_x.shape
    #print train_y.shape
    #print test_x.shape
    #print test_y.shape
    #print train_x
    #print test_y
    
    #print article_timestamps[int(NUM_SAMPLES*.7):][0]
    #print article_timestamps[int(NUM_SAMPLES*.7):][-1]
    
    
    #return train_x, train_y, test_x, test_y  

    
        
    training_data = (train_x, train_y)
    validation_data = (valid_x, valid_y)
    testing_data = (test_x, test_y)
    
    def shared(data):
        """Place the data into shared variables.  This allows Theano to copy
        the data to the GPU, if one is available.

        """
        shared_x = theano.shared(
            np.asarray(data[0], dtype=theano.config.floatX), borrow=True)
        shared_y = theano.shared(
            np.asarray(data[1], dtype=theano.config.floatX), borrow=True)
        return shared_x, T.cast(shared_y, "int32")
    return [shared(training_data), shared(validation_data), shared(testing_data), article_timestamps[int(NUM_SAMPLES*.7):], closing_prices, closing_dates]



def main():
    
    load_data()
    
        
    
if __name__ == "__main__":
    main()
