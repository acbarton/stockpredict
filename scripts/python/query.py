import re
import sys
import operator

def main(BookChapter):

    BookChapterParts = BookChapter.strip().split(":")
    book = BookChapterParts[0]
    chapter = BookChapterParts[1]
    ch = {}
    file = '../../data/' + book + '.txt' 
    dict={}
    key = '1'
    string = ''
    patternString = ' '+chapter+':[0-9]*'
    if book == 'Psalms':
        skip = 5
        heading = 'The Book of Psalms'
        print '<h4>'+heading+'</h4>'
    else:
        skip = 0
    
    #print '<table>'
    #print   '<tr>'
    #print   '<td class="tweetlabel">Tweet: </td>'
    #print   '<td><a id="toggle" class="button" href="javascript:void(0);" onclick="toggleTweets();return false;" >On</a></td>'
    #print   '</tr>'
    #print   '</table><br />'
    print '<p>'
    #pattern = re.compile(" 4:[0-9]*") 
    pattern = re.compile(patternString) 
    with open(file, 'rb') as f:
        lines = f.readlines()
        
        lines.append('{')
        for linei in range(skip, len(lines)):
            line = lines[linei]
            parts = line.strip().split(' ')
            #print parts
            if linei == 1:
                heading = line
                #print '<h4>'+heading+'</h4>'
                continue
            
            for item in parts:
                if '{' in item:
                    #print item
                    #string += '<br />'
                    
                    
          
                    stringParts = string.strip().split('}')
                    
                    
                    if len(stringParts) > 1:
                        #print stringParts
                        
                        key = ' '+stringParts[0].strip().replace('{','')
                        key = key.replace(']','')
                        verse = stringParts[1].strip()
                        
                        verseWithLinks = ''
                        tweetstring = ''
                        verseParts=verse.strip().split(' ')
                        
                        
                        	
                        
                        for i in range(0,len(verseParts)):
                        	if '[' in verseParts[i] and (']' not in verseParts[i] and i == len(verseParts)-1):
                        		verseParts[i] += ']'
                        		
                        		
                        	w = verseParts[i]
                        	
                        	link = '<a id='+w+' title="click for definition" href="#" onclick="myFunction(\''+w+'\');return false;">'+w+'</a>'
                            	verseWithLinks += link + ' '
                            	tweetstring += w + ' ' 
                        """
                        
                        
                        
                        for w in verseParts:
                        
                            if '[' in w and ']' not in w:
                                w += ']'
                                
                                
                            link = '<a id='+w+' title="click for definition" href="#" onclick="myFunction(\''+w+'\');return false;">'+w+'</a>'
                            verseWithLinks += link + ' '
                            tweetstring += w + ' ' 
                        """
                        
                        if re.search(pattern,key):
                            
                            if ':0' in key:
                            	print tweetstring + '<br /><br />'
                            else:
                            	tweet = tweetstring +' '+book+' '+key+ ' http://www.kjvbibletools.com'
                            
                            	print '<a  class="tweetbuttons" href="http://twitter.com/home?status='+tweet+'" ><img class="bird" src="images/tweetbutton.jpeg"/></a>' 
                            
                            	print key + ' ' + verseWithLinks + '<br /><br /> '
                            
                        
                        #dict[' '+stringParts[0].strip().replace('{','')] = stringParts[1].strip()
                        string = ''
                        
                        chap = key.strip().split(':')
                        ch[int(chap[0].replace(']',''))]=1
                        
                #link = '<a id='+item+' title="click for definition" href="#'+item+'" onclick="myFunction(\''+item+'\');">'+item+'</a>'
                string += item + ' '
                
    sortedChapters = sorted(ch.items(), key=operator.itemgetter(0),reverse=False )
    for item in sortedChapters:
        print '<a href="#genesis" onclick="loadChapter(\''+book+':'+str(item[0])+'\');return false;">'+str(item[0])+'</a>'
                
    print '</p>'            
           
            
    
   
    

    

if __name__ == "__main__":
    main(sys.argv[1])