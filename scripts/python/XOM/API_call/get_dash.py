

path='/var/www/html/scripts/python/XOM/'

def main():
    with open(path+"API_call/dash.txt", 'rb') as f:
        lines = f.readlines()
        
    print lines[0]
    
    
if __name__ == "__main__":
    main()