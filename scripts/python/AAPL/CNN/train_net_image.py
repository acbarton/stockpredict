

import network3_attack_deep
from network3_attack_deep import Network
from network3_attack_deep import ConvPoolLayer, FullyConnectedLayer, SoftmaxLayer, ReLU


import load_data

def main():
    
    training_data, validation_data, test_data, article_timestamps = load_data.load_data()
    print "data loaded"
    file=''
    
    mini_batch_size = 10
    epochs = 1000
    
    net = Network(file,[
        ConvPoolLayer(image_shape=(mini_batch_size, 1, 28, 28), 
                      filter_shape=(20, 1, 5, 5), 
                      poolsize=(2, 2), 
                      activation_fn=ReLU),
        ConvPoolLayer(image_shape=(mini_batch_size, 20, 12, 12), 
                      filter_shape=(40, 20, 5, 5), 
                      poolsize=(2, 2), 
                      activation_fn=ReLU),
        FullyConnectedLayer(n_in=640, n_out=200, activation_fn=ReLU, p_dropout=0.5),
        FullyConnectedLayer(n_in=200, n_out=200, activation_fn=ReLU, p_dropout=0.5),
        SoftmaxLayer(n_in=200, n_out=3)], mini_batch_size)
        
        
    net.SGD(training_data, epochs, mini_batch_size, 0.03, 
            validation_data, test_data, lmbda=0.1)
    
    
if __name__ == "__main__":
    main()
