

from HTMLParser import HTMLParser

class MyHTMLParser(HTMLParser):
   
    
    #def handle_starttag(self, tag, attrs):
        #print "Encountered a start tag:", tag

    #def handle_endtag(self, tag):
        #print "Encountered an end tag :", tag

    def handle_data(self, data):
        
        size = data.strip().split(' ')
        if len(size) > 1:
            #print "Encountered some data  :", len(data), data
            print data
        



def main():

    with open("ProQuestExxon-2018-09-07.html", 'rb') as f:
        lines = f.readlines()
        
        for i in range(0, len(lines)):
            line = lines[i]
            
            
            # instantiate the parser and fed it some HTML
            parser = MyHTMLParser()
            parser.feed(line)
            
    
            
            

if __name__ == "__main__":
    main()
