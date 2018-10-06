

path='/var/www/html/scripts/python/AAPL/'

def main():
    with open(path+"API_call/dash.txt", 'rb') as f:
        lines = f.readlines()
        
    print lines[0]
    
    
if __name__ == "__main__":
    main()