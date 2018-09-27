
import load_data
import cPickle as pickle
import numpy as np

from gensim import utils
from gensim.models.doc2vec import LabeledSentence
from gensim.models import Doc2Vec

import theano
import theano.tensor as T

path='/var/www/html/scripts/python/TSLA/'

def gen_samples_on_news_dates():
    
    print "generating images..." 
    closing_prices=[]
    closing_dates=[]
    load_data.load_prices(closing_prices,closing_dates)
    closing_prices.reverse()
    closing_dates.reverse()
    article_timestamps=[]
    data=[]
    load_data.load_article_timestamps(article_timestamps)
    NUM_SAMPLES = len(article_timestamps)
    #print article_timestamps
    for i in range(0,NUM_SAMPLES):
        print i
        sample_date = article_timestamps[i]
        stock_prices = []
        for j in range(0,len(closing_dates)):
            
            if sample_date == closing_dates[j]:
                #print sample_date, closing_dates[j]
                for k in xrange(0,5):
                    stock_prices.append(closing_prices[j-k])
                stock_prices.reverse()
                image = load_data.prices2image(stock_prices,sample_date)
                stock_prices = []
                data.append(image)
                break
                
            if sample_date > closing_dates[j-1] and sample_date < closing_dates[j]:
                #print sample_date, closing_dates[j]
                for k in xrange(0,5):
                    stock_prices.append(closing_prices[j-k])
                stock_prices.reverse()
                image = load_data.prices2image(stock_prices,sample_date)
                stock_prices = []
                data.append(image)
                break
                
        #print data
        
    with open("figs/images.pkl", "wb") as fp:   
        pickle.dump(data, fp)
    
    
def gen_samples_images():
    
    print "generating images..." 
    closing_prices=[]
    closing_dates=[]
    load_data.load_prices(closing_prices,closing_dates)
    closing_prices.reverse()
    closing_dates.reverse()
    article_timestamps=[]
    data=[]
    load_data.load_article_timestamps(article_timestamps)
    
    
    stock_prices = []
    #4282
    for j in range(4282,len(closing_dates)-10):
        print j  
        for k in xrange(0,60):
            stock_prices.append(closing_prices[j-k])
        stock_prices.reverse()
        image = load_data.prices2image(stock_prices,1)
        data.append(image)
        stock_prices = []
        
        #print data
        
    with open("figs/images_all_dates.pkl", "wb") as fp:   
        pickle.dump(data, fp)
        
def gen_samples_All(model):
    
    print "generating images..." 
    closing_prices=[]
    closing_dates=[]
    load_data.load_prices(closing_prices,closing_dates)
    closing_prices.reverse()
    closing_dates.reverse()
    article_timestamps=[]
    data=[]
    load_data.load_article_timestamps(article_timestamps)
    
    #print len(closing_dates)
    stock_prices = []
    #4282
    for j in range(382,len(closing_dates)-10):
        #print j
        print closing_dates[j]
        for k in xrange(0,15):
            stock_prices.append(closing_prices[j-k])
        stock_prices.reverse()
        image = load_data.prices2image(stock_prices,1)
        stock_prices=[]
        #print image.shape
        flag=0
        for z in xrange(0,len(article_timestamps)):
            if article_timestamps[z] == closing_dates[j]:
                #print model[z].size
                for m in model[z]:
                    #print model[z] 
                    image = np.append(image, m)
                    #print image
                flag=1
                data.append(image)
                break
            elif article_timestamps[z] > closing_dates[j] and article_timestamps[z] < closing_dates[j+1] :
                for m in model[z]:
                    image = np.append(image, m)
                flag = 1
                data.append(image)
                break
        if flag == 1:
            flag = 0
            continue
        elif flag == 0:
            for m in model[z]:
                image = np.append(image, 0.0)
            data.append(image)
            
        
        
    with open("figs/images_vecs_all_dates.pkl", "wb") as fp:   
        pickle.dump(data, fp)
        
def form_data_point(days):
    
    model = Doc2Vec.load(path+'word2vec-sentiments/pvecs_99.d2v')
    
    #print "forming data point..." 
    closing_prices=[]
    closing_dates=[]
    load_data.load_prices(closing_prices,closing_dates)
    closing_prices.reverse()
    closing_dates.reverse()
    article_timestamps=[]
    data=[]
    load_data.load_article_timestamps(article_timestamps)
    test_data=[]
    with open(path+"CNN/figs/images_vecs_all_dates.pkl", "rb") as fp:   # Unpickling
        test_data = pickle.load(fp)
    
    stock_prices = []
    #4282
    #print len(closing_dates)
    
    for j in range(len(closing_dates)-days,len(closing_dates)):
        #print j
        for k in xrange(0,15):
            stock_prices.append(closing_prices[j-k])
        stock_prices.reverse()
        image = load_data.prices2image(stock_prices,1)
        stock_prices=[]
        #print image.shape
        flag=0
        for z in xrange(0,len(article_timestamps)):
            if article_timestamps[z] == closing_dates[j]:
                #print 'date match'
                #print model[z].size
                for m in model[z]:
                    image = np.append(image, m)
                flag=1
                test_data.append(image)
                break
            elif article_timestamps[z] > closing_dates[j] and article_timestamps[z] < closing_dates[j+1] :
                #print 'date match'
                for m in model[z]:
                    image = np.append(image, m)
                flag=1
                test_data.append(image)
                break
        if flag == 1:
            flag = 0
            continue
        elif flag == 0:
            for m in model[z]:
                image = np.append(image, 0.0)
            test_data.append(image)
     
        
   
        
    
 
    
            
    test_data = np.array(test_data,dtype=np.float32)
    #print test_data.shape
    test_data = load_data.scale(test_data)
    data_points = test_data[-days:]
    #data_points = data_points.reshape((324,1))
    #print data_points.shape
    return data_points
        
    

def main():
    
    model = Doc2Vec.load('../word2vec-sentiments/pvecs_99.d2v')
    
    #gen_samples_images()
    gen_samples_All(model)
    #form_data_point()
    
    
    
    
    
    

if __name__ == "__main__":
    main()
