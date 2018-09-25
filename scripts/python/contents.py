#!/usr/bin/python


import re
import operator
import sys

def main(Book):
    
    file='../../data/'+Book + '.txt'
    chapter={}
    dict={}
    key = '1'
    string = ''
    flag = 0
    heading = ''
    if Book == 'Psalms':
        skip = 4
        heading = 'The Book of Psalms'
        print '<h4>'+heading+'</h4>'
    else:
        skip = 0
    print '<p>'
    pattern = re.compile(" 48:[0-9]*") 
    with open(file, 'rb') as f:
        lines = f.readlines()
        
        
        for linei in range(skip, len(lines)):
            line = lines[linei]
            parts = line.strip().split(' ')
            if 'Psalm' in parts:
                continue
            if linei == 1:
                heading = line
                print '<h4>'+heading+'</h4>'
                continue
                
            for item in parts:
                if '{' in item:
                    
                    #string += '<br />'
                    stringParts = string.strip().split('}')
                    if len(stringParts) > 1:
                        #print stringParts
                        
                        key = ' '+stringParts[0].strip().replace('{','')
                        verse = stringParts[1].strip()
                        
                        verseWithLinks = ''
                        verseParts=verse.strip().split(' ')
                        for w in verseParts:
                            link = '<a id='+w+' title="click for definition" href="#" onclick="myFunction(\''+w+'\');return false;">'+w+'</a>'
                            verseWithLinks += link + ' '
                            
                            
                        #if re.search(pattern,key):
                        #print key + '<br /><br /> '
                        chap = key.strip().split(':')
                        #keypattern = re.compile(' [a-zA-Z]*')
                        
                        #if re.search(keypattern,chap[0].replace(']','')):
                            #print chap
                            #continue
                        chapter[int(chap[0].replace(']',''))]=1
                        
                        #dict[' '+stringParts[0].strip().replace('{','')] = stringParts[1].strip()
                        string = ''
                #link = '<a id='+item+' title="click for definition" href="#'+item+'" onclick="myFunction(\''+item+'\');">'+item+'</a>'
                string += item + ' '
    
    sortedChapters = sorted(chapter.items(), key=operator.itemgetter(0),reverse=False )
    print '<table id="chapterButtons">';
    flag = 0
    for item in sortedChapters:
        if flag == 0:
            print '<tr>'
       
        print '<td   ><a class="button"  href="#" onclick="loadChapter(\''+Book+':'+str(item[0])+'\');return false;">'+str(item[0])+'</a></td>'
    
        if flag == 6:
            print '</tr>'
            flag = 0
    
        flag += 1
    
    print '</table>';
    print '</p>';
               
           
            
    
   
    

    

if __name__ == "__main__":
    
    main(sys.argv[1])