
import re
# gensim modules
from gensim import utils
from gensim.models.doc2vec import LabeledSentence
from gensim.models import Doc2Vec

# numpy
import numpy

# random
from random import shuffle

from datetime import datetime

def main():
    
    flag = 0
    buff = []
    title=[]
    article=[]
    
    articles=[]
    dates=[]
    
    with open("xom_articles.txt", 'rb') as f:
        lines = f.readlines()
        
        for i in range(0, len(lines)):
            line = lines[i]
            parts = line.strip().split(' ')
            #print parts
            
            if len(parts) == 4 and 'The' in parts and 'Wall' in parts and 'Street' in parts and 'Journal' in parts:
                title = lines[i+1].strip().split(' ')
                for j in range(0,len(title)):
                    title[j] = re.sub(r'[^a-zA-Z_0-9]', '', title[j])
                    title[j] = title[j].lower()
                #print title
            if len(parts) == 2 and 'Full' in parts and 'text:' in parts:
                flag = 1
                
            if 'Credit:' in parts[0] and 'By' in parts[1]:
                flag = 0
                #print buff[2:]
                for j in range(0,len(buff)):
                    buff[j] = re.sub(r'[^a-zA-Z_0-9]', '', buff[j])
                    buff[j] = buff[j].lower()
                article = title + buff[2:]
                buff = []
            
            if flag == 1:
                buff += parts
                
            if len(parts) == 2 and 'Publication' in parts and 'date:' in parts:
                date = lines[i+1].strip().split(' ')
                
                if len(date) == 3:
                    date = date[0]+' '+date[1]+' '+date[2]
                    timestamp = datetime.strptime(date, '%b %d, %Y')
                if len(date) == 4:
                    date = date[0]+' '+date[1]+date[2]+' '+date[3]
                    timestamp = datetime.strptime(date, '%b %d, %Y')
                
                dates.append(str(timestamp))
                articles.append(article)
    
    
    
    f = open('train_articles.txt','wb')
    for a in articles:
        for w in a:
            f.write(w + ' ')
        f.write('\n')
    f.close()
    
    f = open('article_timestamps.txt','wb')
    for d in dates:
        f.write(d + '\n')
        #print d
    f.close()
    
    
    
   
                
                
if __name__ == "__main__":
    main()
