


import sys

import network3_attack_deep
from network3_attack_deep import Network
from network3_attack_deep import ConvPoolLayer, FullyConnectedLayer, SoftmaxLayer, ReLU


sys.path.insert(0, '/var/www/html/scripts/python/TSLA/CNN/')
import load_data



def main():
    
    path ='/var/www/html/scripts/python/TSLA/CNN/'
    
    layer1_dim = 18
    layer2_dim = 7
    conv_out = 360
    fully_out = 200
    file=path+'CNN_model_images_vecs_success.pkl'
    
   
    
    """
    layer1_dim = 32
    layer2_dim = 14
    conv_out = 1440
    fully_out = 200
    file='CNN_model_images_vecs.pkl'
  
    
    
    layer1_dim = 28
    layer2_dim = 13
    conv_out = 1000
    fully_out = 200
    file='CNN_model_images_vecs.pkl'
    
    
    layer1_dim = 26
    layer2_dim = 11
    conv_out = 1000
    fully_out = 200
    file='CNN_model_images.pkl'
    
    
    layer1_dim = 10
    layer2_dim = 3
    conv_out = 40
    fully_out = 20
    file='CNN_model_pvec100.pkl'
    """
    
    training_data, validation_data, test_data, article_timestamps, closing_prices, closing_dates = load_data.load_data()
    #print "data loaded"
    
    
    mini_batch_size = 1
    epochs = 50
    
    net = Network(file,[
        ConvPoolLayer(image_shape=(mini_batch_size, 1, layer1_dim, layer1_dim), 
                      filter_shape=(20, 1, 5, 5), 
                      poolsize=(2, 2), 
                      activation_fn=ReLU),
        ConvPoolLayer(image_shape=(mini_batch_size, 20, layer2_dim, layer2_dim), 
                      filter_shape=(40, 20, 2, 2), 
                      poolsize=(2, 2), 
                      activation_fn=ReLU),
        FullyConnectedLayer(n_in=conv_out, n_out=fully_out, activation_fn=ReLU, p_dropout=0.0),
        FullyConnectedLayer(n_in=fully_out, n_out=fully_out, activation_fn=ReLU, p_dropout=0.0),
        SoftmaxLayer(n_in=fully_out, n_out=3)], mini_batch_size)
        
        
    net.Test_Net_Predict(training_data, epochs, mini_batch_size, 0.03, 
            validation_data, test_data, article_timestamps, closing_prices, closing_dates, lmbda=0.1)
    
    
if __name__ == "__main__":
    main()
