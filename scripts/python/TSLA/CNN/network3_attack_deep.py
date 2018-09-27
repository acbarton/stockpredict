"""network3.py
~~~~~~~~~~~~~~

A Theano-based program for training and running simple neural
networks.

Supports several layer types (fully connected, convolutional, max
pooling, softmax), and activation functions (sigmoid, tanh, and
rectified linear units, with more easily added).

When run on a CPU, this program is much faster than network.py and
network2.py.  However, unlike network.py and network2.py it can also
be run on a GPU, which makes it faster still.

Because the code is based on Theano, the code is different in many
ways from network.py and network2.py.  However, where possible I have
tried to maintain consistency with the earlier programs.  In
particular, the API is similar to network2.py.  Note that I have
focused on making the code simple, easily readable, and easily
modifiable.  It is not optimized, and omits many desirable features.

This program incorporates ideas from the Theano documentation on
convolutional neural nets (notably,
http://deeplearning.net/tutorial/lenet.html ), from Misha Denil's
implementation of dropout (https://github.com/mdenil/dropout ), and
from Chris Olah (http://colah.github.io ).

Written for Theano 0.6 and 0.7, needs some changes for more recent
versions of Theano.

"""

import matplotlib
matplotlib.use('Agg')
#### Libraries
import matplotlib.pyplot as plt
# Standard library
import cPickle
import pickle
import gzip
#from PIL import Image, ImageDraw, ImageFont
import random

# Third-party libraries
import numpy as np
import theano
import theano.tensor as T
from theano.tensor.nnet import conv
from theano.tensor.nnet import softmax
from theano.tensor import shared_randomstreams
from theano.tensor.signal import pool

# Activation functions for neurons
def linear(z): return z
def ReLU(z): return T.maximum(0.0, z)
from theano.tensor.nnet import sigmoid
from theano.tensor import tanh

import generate_images

#### Constants

GPU = True
if GPU:
    #print ("Trying to run under a GPU.  If this is not desired, then modify "+\
        #"network3.py\nto set the GPU flag to False.")
    try: theano.config.device = 'gpu'
    except: pass # it's already set
    theano.config.floatX = 'float32'
else:
    print ''
    #print ("Running with a CPU.  If this is not desired, then the modify "+\
        #"network3.py to set\nthe GPU flag to True.")

#### Load the MNIST data
def load_data_shared(filename="/home/abarton/NetBeansProjects/NNet/src/data/mnist.pkl.gz"):
    f = gzip.open(filename, 'rb')
    training_data, validation_data, test_data = cPickle.load(f) #tuples of numpy ndarrays
    for i in range(0,training_data[0].shape[0]):
        training_data[0][i] = (training_data[0][i] - 0.5)
        
    for i in range(0,validation_data[0].shape[0]):
        validation_data[0][i] = (validation_data[0][i] - 0.5)
        
    for i in range(0,test_data[0].shape[0]):
        test_data[0][i] = (test_data[0][i] - 0.5)
    print training_data[0].shape
    print training_data[1].shape
    #print '-----'
    #print type(training_data[0])  
    f.close()
    def shared(data):
        """Place the data into shared variables.  This allows Theano to copy
        the data to the GPU, if one is available.

        """
        shared_x = theano.shared(
            np.asarray(data[0], dtype=theano.config.floatX), borrow=True)
        shared_y = theano.shared(
            np.asarray(data[1], dtype=theano.config.floatX), borrow=True)
        return shared_x, T.cast(shared_y, "int32")
    return [shared(training_data), shared(validation_data), shared(test_data)]

#### Load the MNIST data
def load_padded_data_shared(filename="/home/abarton/NetBeansProjects/NNet/src/data/uniform_threshold_padding_noise_class.pkl"):
    f = open(filename, 'rb')
    #training_data, validation_data, test_data = cPickle.load(f) #tuples of numpy ndarrays
    training_data = cPickle.load(f)
    validation_data = cPickle.load(f)
    test_data = cPickle.load(f)
    #print training_data[0].shape
    
    #print training_data[0][0].reshape(784,)
    #print training_data
    #print '-----'
    #print type(training_data[0])  
    f.close()
    def shared(data):
        """Place the data into shared variables.  This allows Theano to copy
        the data to the GPU, if one is available.

        """
        shared_x = theano.shared(
            np.asarray(data[0], dtype=theano.config.floatX), borrow=True)
        shared_y = theano.shared(
            np.asarray(data[1], dtype=theano.config.floatX), borrow=True)
        return shared_x, T.cast(shared_y, "int32")
    return [shared(training_data), shared(validation_data), shared(test_data)]



def load_adv_test_data(filename="/home/abarton/NetBeansProjects/NNet_onevsall/src/adv_examples/carlini_examples/carliniLi_targeted.pkl"):
    f = open(filename, 'rb')
    adv_test_data = cPickle.load(f)
    print adv_test_data[0].shape
    print adv_test_data[1].shape
    
    printImage(adv_test_data[0][0])
    
    shared_x = theano.shared(
        np.asarray(adv_test_data[0], dtype=theano.config.floatX), borrow=True)
    shared_y = theano.shared(
        np.asarray(adv_test_data[1], dtype=theano.config.floatX), borrow=True)
    return shared_x, T.cast(shared_y, "int32")
  
def load_adv_test_data_labels(filename="/home/abarton/NetBeansProjects/NNet_onevsall/src/adv_examples/IGSM_0.4.pkl"):
    f = open(filename, 'rb')
    adv_test_data = cPickle.load(f)
    return adv_test_data[1]

def printImage(datax):
        h, w = 28, 28    
        datax.resize((h,w))
        img = Image.fromarray((datax+0.5)*255)
    
        #print data
        
        img.show()
        #img.convert('RGB')
        #img.save('images/'+attack+'_'+str(org)+"_"+str(tar)+".jpeg")
    
    

#### Main class used to construct and train networks
class Network(object):

    def __init__(self,file, layers, mini_batch_size):
        """Takes a list of `layers`, describing the network architecture, and
        a value for the `mini_batch_size` to be used during training
        by stochastic gradient descent.

        """
        self.layers = layers
        self.mini_batch_size = mini_batch_size
        self.LoadParams(file)
        self.params = [param for layer in self.layers for param in layer.params]
        self.x = T.matrix("x")
        self.y = T.ivector("y")
        init_layer = self.layers[0]
        init_layer.set_inpt(self.x, self.x, self.mini_batch_size)
        for j in range(1, len(self.layers)):
            prev_layer, layer  = self.layers[j-1], self.layers[j]
            layer.set_inpt(
                prev_layer.output, prev_layer.output_dropout, self.mini_batch_size)
        self.output = self.layers[-1].output
        self.output_dropout = self.layers[-1].output_dropout
    
    def converttoshared(self,adv_test_data):
    
        shared_x = theano.shared(
            np.asarray(adv_test_data[0], dtype=theano.config.floatX), borrow=True)
        shared_y = theano.shared(
            np.asarray(adv_test_data[1], dtype=theano.config.floatX), borrow=True)
        return shared_x, T.cast(shared_y, "int32")
    
    def LoadParams(self,file):
        list=[]
        f = open(file, 'rb')
        for layer in self.layers:
            layer.w = theano.shared(cPickle.load(f))
            layer.b = theano.shared(cPickle.load(f))
            layer.params=[layer.w, layer.b]
        f.close
     
        
    
    def SGD(self, training_data, epochs, mini_batch_size, eta,
            validation_data, test_data, lmbda=0.0):
        """Train the network using mini-batch stochastic gradient descent."""
        training_x, training_y = training_data
        validation_x, validation_y = validation_data
        test_x, test_y = test_data

        # compute number of minibatches for training, validation and testing
        num_training_batches = int (size(training_data)/mini_batch_size )
        num_validation_batches = int (size(validation_data)/mini_batch_size)
        num_test_batches = int (size(test_data)/mini_batch_size)

        # define the (regularized) cost function, symbolic gradients, and updates
        
        
        
        #------------------AGT-------------------
        cost1 = self.layers[-1].costAGT(self,0)
        cost2 = self.layers[-1].costAGT(self,1)
        cost3 = self.layers[-1].costAGT(self,2)
        cost4 = self.layers[-1].costAGT(self,3)
        cost5 = self.layers[-1].costAGT(self,4)
        cost6 = self.layers[-1].costAGT(self,5)
        cost7 = self.layers[-1].costAGT(self,6)
        cost8 = self.layers[-1].costAGT(self,7)
        cost9 = self.layers[-1].costAGT(self,8)
        cost10 = self.layers[-1].costAGT(self,9)
        
        attgrad1 = T.grad(cost1,self.x)
        attgrad2 = T.grad(cost2,self.x)
        attgrad3 = T.grad(cost3,self.x)
        attgrad4 = T.grad(cost4,self.x)
        attgrad5 = T.grad(cost5,self.x)
        attgrad6 = T.grad(cost6,self.x)
        attgrad7 = T.grad(cost7,self.x)
        attgrad8 = T.grad(cost8,self.x)
        attgrad9 = T.grad(cost9,self.x)
        attgrad10 = T.grad(cost10,self.x)
        
        #agr = T.mean(attgrad1**2) + T.mean(attgrad2**2) + T.mean(attgrad3**2) + T.mean(attgrad4**2) + T.mean(attgrad5**2) \
            #+ T.mean(attgrad6**2) + T.mean(attgrad7**2) + T.mean(attgrad8**2) + T.mean(attgrad9**2) + T.mean(attgrad10**2)
        
        agr = int(T.argmax(self.y) != 0) * T.mean(attgrad1**2) + int(T.argmax(self.y) != 1) * T.mean(attgrad2**2) + int(T.argmax(self.y) != 2) * T.mean(attgrad3**2) + int(T.argmax(self.y) != 3) * T.mean(attgrad4**2) + int(T.argmax(self.y) != 4)* T.mean(attgrad5**2) \
            + int(T.argmax(self.y) != 5) * T.mean(attgrad6**2) + int(T.argmax(self.y) != 6) * T.mean(attgrad7**2) + int(T.argmax(self.y) != 7) * T.mean(attgrad8**2) + int(T.argmax(self.y) != 8) * T.mean(attgrad9**2) + int(T.argmax(self.y) != 9) * T.mean(attgrad10**2)    
        
        
        #s = .5
        #cost = s * self.layers[-1].cost(self) + (1-s) * agr  #+  0.5*lmbda*l2_norm_squared/num_training_batches
        
        #----------------Unprotected-----------------------
        l2_norm_squared = sum([(layer.w**2).sum() for layer in self.layers])
        ######cost = s * self.layers[-1].cost(self) + (1-s)*T.mean(attgrad) #+  0.5*lmbda*l2_norm_squared/num_training_batches
        cost = self.layers[-1].cost(self) +  0.5*lmbda*l2_norm_squared/num_training_batches
        
        #----------------Gradiant Training------------------
        #s = .5
        #cost2 = self.layers[-1].costAGT(self,10)
        #attgrad = T.grad(cost2,self.x)
        #####cost = s * self.layers[-1].cost(self) + (1-s)* T.mean(attgrad**2) #this works somewhat....
        #cost = self.layers[-1].cost(self) +  .01 * T.mean(attgrad**2) + 0.5*lmbda*l2_norm_squared/num_training_batches #works somewhat with good accuracy, use datay in cost func.
        ######cost = self.layers[-1].cost(self) + .01 * T.sqrt(T.mean(attgrad**2)) #didn't work
        ######cost =  self.layers[-1].cost(self) + (.01 *   T.mean((self.x - ( self.x-(.25*T.sgn(attgrad))   ))**2) )
        
        
 
        
       
        
        
        #-----------------Adversarial Training---------------
        #s=.5
        #cost2 = self.layers[-1].costAGT(self,0)
        #attgrad = T.grad(cost2,self.x)
        #cost = s * self.layers[-1].cost(self) + (1-s)* T.mean(( self.x+(.25*T.sgn(attgrad)) )**2) #doesn't work
        
        
        
        
         
        
        grads = T.grad(cost, self.params)
        
        updates = [(param, param-eta*grad)
                   for param, grad in zip(self.params, grads)]

        # define functions to train a mini-batch, and to compute the
        # accuracy in validation and test mini-batches.
        i = T.lscalar() # mini-batch index
        train_mb = theano.function(
            [i], cost, updates=updates,
            givens={
                self.x:
                training_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                training_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        validate_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                validation_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                validation_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        test_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                test_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        self.test_mb_predictions = theano.function(
            [i], self.layers[-1].y_out,
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        
        # Do the actual training
        early_count = 0
        best_validation_accuracy = 0.0
        for epoch in range(epochs):
            for minibatch_index in range(num_training_batches):
                iteration = num_training_batches*epoch+minibatch_index
                if iteration % 1000 == 0:
                    print("Training mini-batch number {0}".format(iteration))
                cost_ij = train_mb(minibatch_index)
                if (iteration+1) % num_training_batches == 0:
                    validation_accuracy = np.mean(
                        [validate_mb_accuracy(j) for j in range(num_validation_batches)])
                    print("Epoch {0}: validation accuracy {1:.2%}".format(
                        epoch, validation_accuracy))
                    f = open('output.txt','a+')
                    f.write( "Epoch {0}: validation accuracy {1:.2%}\n".format(
                        epoch, validation_accuracy) )
                    f.close()
                    if validation_accuracy >= best_validation_accuracy:
                        early_count = 0
                        print("This is the best validation accuracy to date.")
                        best_validation_accuracy = validation_accuracy
                        best_iteration = iteration
                        self.write_params() #Un comment when training a new network!!!!!!!!!!!!!!!!
                        if test_data:
                            test_accuracy = np.mean(
                                [test_mb_accuracy(j) for j in range(num_test_batches)])
                            print('The corresponding test accuracy is {0:.2%}'.format(
                                test_accuracy))
                    else:
                        early_count += 1
            if early_count >= 150:
                break           
                            
                            
        print("Finished training network.")
        print("Best validation accuracy of {0:.2%} obtained at iteration {1}".format(
            best_validation_accuracy, best_iteration))
        print("Corresponding test accuracy of {0:.2%}".format(test_accuracy))
        accuracy = "{0:.2%}". format(test_accuracy)
        
        #self.attack_iter(test_x, test_y,accuracy,100)
        #print self.params
        
        
        
        
        #self.Test_Net(training_data, epochs, mini_batch_size, eta,
            #validation_data, test_data, lmbda=0.0)
            
    def write_params(self):
        fp = open('CNN_model_images_vecs.pkl','wb')
        for layer in self.layers:
            cPickle.dump(layer.w.get_value(),fp,protocol=cPickle.HIGHEST_PROTOCOL)
            cPickle.dump(layer.b.get_value(),fp,protocol=cPickle.HIGHEST_PROTOCOL)
        fp.close()
    
    def lookup_price(self,article_stamp,closing_prices, closing_dates):
        
        
        for j in range(0,len(closing_dates)):
            if article_stamp == closing_dates[j]:
                return closing_prices[j], j
            if article_stamp > closing_dates[j-1] and article_stamp < closing_dates[j]:
                return closing_prices[j], j
    
    def stock_simulate_last_30(self, j, pred, own, shares, investment, closing_prices,closing_dates):
        
        closing_price = closing_prices[j]
        closing_date = closing_dates[j]
        
        if pred == 1 and own[0] == 0:
            shares[0] = investment[0] / closing_price
            own[0] = 1
            plt.annotate('buy',xy=(closing_date,closing_price))
            return pred
        elif pred == 1 and own[0] == 1:
            return -1
        elif pred == 0 and own[0] == 1:
            investment[0] = shares[0] * closing_price
            plt.annotate('sell',xy=(closing_date,closing_price))
            #print investment[0]
            own[0] = 0
            return pred
        elif pred == 0 and own[0] == 0:
            return -1 
    
    def stock_simulate_all_dates(self, j, pred, own, shares, investment, closing_prices):
        #xaxis=[]
        #for x in range(5452,len(closing_prices)-10):
            #xaxis.append(x)
        print len(closing_prices)
        closing_price = closing_prices[j+1571]
        #print closing_price
        if pred == 1 and own[0] == 0:
            shares[0] = investment[0] / closing_price
            own[0] = 1
            #plt.annotate('buy',xy=(xaxis[j],closing_price))
            return 
        elif pred == 1 and own[0] == 1:
            return 
        elif pred == 0 and own[0] == 1:
            investment[0] = shares[0] * closing_price
            #plt.annotate('sell',xy=(xaxis[j],closing_price))
            print investment[0]
            own[0] = 0
            return 
        elif pred == 0 and own[0] == 0:
            return            
                    
    def stock_simulate_news_dates(self, j, pred, own, investment, closing_prices,closing_dates,article_timestamps):
        
        if pred == 1 and own == 0:
            #print closing_prices[j]
            closing_price, xiter = self.lookup_price(article_timestamps[j],closing_prices,closing_dates)
            shares = investment / closing_price
            own = 1
            plt.annotate('buy',xy=(xiter,closing_price))
            return
        elif pred == 1 and own == 1:
            return
        elif pred == 0 and own == 1:
            closing_price, xiter = self.lookup_price(article_timestamps[j],closing_prices,closing_dates)
            investment = shares * closing_price
            plt.annotate('sell',xy=(xiter,closing_price))
            print investment
            own = 0
            return
        elif pred == 0 and own == 0:
            return
            
    def Test_Net(self, training_data, epochs, mini_batch_size, eta,
            validation_data, test_data, article_timestamps, closing_prices, closing_dates, lmbda=0.0):
        """Train the network using mini-batch stochastic gradient descent."""
        training_x, training_y = training_data
        validation_x, validation_y = validation_data
        test_x, test_y = test_data
        
        #self.LoadParams()
        #print self.params

        # compute number of minibatches for training, validation and testing
        num_training_batches = int (size(training_data)/mini_batch_size )
        num_validation_batches = int (size(validation_data)/mini_batch_size)
        num_test_batches = int (size(test_data)/mini_batch_size)

        
        i = T.lscalar() # mini-batch index
        validate_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                validation_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                validation_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        test_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                test_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        self.test_mb_predictions = theano.function(
            [i], self.layers[-1].y_out,
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        # Do Test
        print "Test data size: " + str(size(test_data))
        test_accuracy = np.mean([test_mb_accuracy(j) for j in range(num_test_batches)])
        investment = [100000.0]
        print investment[0]
        starting_investment = investment[0]
        shares = [0.0]
        own = [0]
        xaxis=[]
        #for x in range(0,len(closing_prices)):
            #xaxis.append(x)
        #plt.plot(closing_prices, lw=2)
    
        for j in range(num_test_batches):
            #print article_timestamps[j]
            pred = self.test_mb_predictions(j)
            #print pred
            
            #self.stock_simulate_news_dates(j, pred, own, investment, closing_prices,closing_dates,article_timestamps)
            self.stock_simulate_all_dates(j, pred, own, shares, investment,  closing_prices)
            
        
        print 'starting investment: '+ str(starting_investment)
        print 'final investment: ' + str(investment)
        
            
        print('The corresponding test accuracy is {0:.2%}'.format(test_accuracy))
        accuracy = "{0:.2%}". format(test_accuracy)
        
        """
        path='/var/www/html/scripts/python/TSLA/'
        plt.show()
        fig=plt.gcf()
        fig.savefig(path+'CNN/display/xom_image.png', bbox_inches='tight',dpi=None, facecolor='w', edgecolor='w',
        orientation='portrait', papertype=None, format=None,
        transparent=False, pad_inches=0.1,
        frameon=None)
        #plt.show()
        """
        
    def Test_Net_Predict(self, training_data, epochs, mini_batch_size, eta,
            validation_data, test_data, article_timestamps, closing_prices, closing_dates, lmbda=0.0):
        """Train the network using mini-batch stochastic gradient descent."""
        training_x, training_y = training_data
        validation_x, validation_y = validation_data
        test_x, test_y = test_data
        #test_x = test_x[472:]
        #test_y = test_y[472:]
        
        
        #self.LoadParams()
        #print self.params

        # compute number of minibatches for training, validation and testing
        num_training_batches = int (size(training_data)/mini_batch_size )
        num_validation_batches = int (size(validation_data)/mini_batch_size)
        num_test_batches = int (size(test_data)/mini_batch_size)
        #num_test_batches = 30
        test_data_size = int (size(test_data))
        #print '++++=============='
        #print test_x.get_value(borrow=True).shape[0]
        
        i = T.lscalar() # mini-batch index
        validate_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                validation_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                validation_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        test_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                test_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        self.test_mb_predictions = theano.function(
            [i], self.layers[-1].y_out,
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        #dp = T.matrix("data_point")
        predict = theano.function(
            [self.x], self.layers[-1].y_out,
            )
        
        # Do Test
        #print "Test data size: " + str(size(test_data))
        test_accuracy = np.mean([test_mb_accuracy(j) for j in range(num_test_batches)])
        investment = [100000.0]
        #print investment[0]
        starting_investment = investment[0]
        shares = [0.0]
        own = [0]
        xaxis=[]
        days = 10
        #for x in range(0,30):
            #xaxis.append(x)
            
        #print len(closing_prices[-days:])
        
        
        data_points = generate_images.form_data_point(days)
        plt.plot(closing_dates[-days:],closing_prices[-days:], lw=2)
        plt.xticks(rotation=70)
        actcount=0
        lastact = -1
        for j in range(0,days):
            d = data_points[j]
            d = d.reshape((324,1))
            #print "Prediction: " + str(predict(d))
            pred = predict(d)
        
            #self.stock_simulate_news_dates(j, pred, own, investment, closing_prices,closing_dates,article_timestamps)
            #self.stock_simulate_all_dates(j, pred, own, shares, investment,  closing_prices)
            act = self.stock_simulate_last_30(j,pred,own,shares,investment,closing_prices[-days:],closing_dates[-days:])
            if act > -1:
                if j > actcount:
                    actcount = j
                    lastact = act
                    
        date = closing_dates[-days:][actcount]            
        #print actcount
        #print lastact
        
        if lastact == 0:
            print "<p>Our most recent indicator was <b style=\"color:red;\">Sell</b> given on <b>"+ str(date)[:10] +"</b></p>"           
        if lastact == 1:
            print "<p>Our most recent indicator was <b style=\"color:green;\">Buy</b> given on <b>"+ str(date)[:10] +"</b></p>"
        
        #print 'starting investment: '+ str(starting_investment)
        #print 'final investment: ' + str(investment)
        
            
        #print('The corresponding test accuracy is {0:.2%}'.format(test_accuracy))
        accuracy = "{0:.2%}". format(test_accuracy)
        #plt.show() 
        path='/var/www/html/scripts/python/TSLA/'
        fig=plt.gcf()
        fig.savefig(path+'CNN/display/tsla.png', bbox_inches='tight',dpi=None, facecolor='w', edgecolor='w',
        orientation='portrait', papertype=None, format=None,
        transparent=False, pad_inches=0.1,
        frameon=None)
        #plt.show()    
        
        print '<h2>TSLA Daily Close: Past '+str(days)+' Days</h2>'
        print '<img src=\"scripts/python/TSLA/CNN/display/tsla.png\" onload=\"loadsim(\'TSLA\')\" >'
        
    def Test_Net_Simulate(self, training_data, epochs, mini_batch_size, eta,
            validation_data, test_data, article_timestamps, closing_prices, closing_dates, investment, days, lmbda=0.0):
        """Train the network using mini-batch stochastic gradient descent."""
        training_x, training_y = training_data
        validation_x, validation_y = validation_data
        test_x, test_y = test_data
        #test_x = test_x[472:]
        #test_y = test_y[472:]
        
        
        #self.LoadParams()
        #print self.params

        # compute number of minibatches for training, validation and testing
        num_training_batches = int (size(training_data)/mini_batch_size )
        num_validation_batches = int (size(validation_data)/mini_batch_size)
        num_test_batches = int (size(test_data)/mini_batch_size)
        #num_test_batches = 30
        test_data_size = int (size(test_data))
        #print '++++=============='
        #print test_x.get_value(borrow=True).shape[0]
        
        i = T.lscalar() # mini-batch index
        validate_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                validation_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                validation_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        test_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                test_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        self.test_mb_predictions = theano.function(
            [i], self.layers[-1].y_out,
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        #dp = T.matrix("data_point")
        predict = theano.function(
            [self.x], self.layers[-1].y_out,
            )
        
        # Do Test
        #print "Test data size: " + str(size(test_data))
        test_accuracy = np.mean([test_mb_accuracy(j) for j in range(num_test_batches)])
        #investment = [100000.0]
        #print investment[0]
        starting_investment = investment[0]
        shares = [0.0]
        own = [0]
        xaxis=[]
        #days = 5
        #for x in range(0,30):
            #xaxis.append(x)
            
        #print len(closing_prices[-days:])
        
        
        data_points = generate_images.form_data_point(days)
        plt.plot(closing_dates[-days:],closing_prices[-days:], lw=2)
        plt.xticks(rotation=70)
        actcount=0
        lastact = -1
        for j in range(0,days):
            d = data_points[j]
            d = d.reshape((324,1))
            #print "Prediction: " + str(predict(d))
            pred = predict(d)
        
            #self.stock_simulate_news_dates(j, pred, own, investment, closing_prices,closing_dates,article_timestamps)
            #self.stock_simulate_all_dates(j, pred, own, shares, investment,  closing_prices)
            act = self.stock_simulate_last_30(j,pred,own,shares,investment,closing_prices[-days:],closing_dates[-days:])
            if act > -1:
                if j > actcount:
                    actcount = j
                    lastact = act
                    
             
        print '<p>Starting investment: <b>$%.2f</b></p>' % starting_investment
        
        if investment[0] >= starting_investment:
            print "<p>Final investment value: <b style=\"color:green;\">$%.2f</b></p>" %  investment[0]
            print '<p>Profit: <b style=\"color:green;\">$%.2f</b></p>' % (investment[0] - starting_investment)
            print '<p>Return: +%.2f%%' % ((( investment[0]/starting_investment)-1) * 100)
        if investment[0] < starting_investment:
            print "<p>Final investment value: <b style=\"color:red;\">"+str(investment[0])+"</b></p>"
            
        
        
        #print 'starting investment: '+ str(starting_investment)
        #print 'final investment: ' + str(investment)
        
            
        #print('The corresponding test accuracy is {0:.2%}'.format(test_accuracy))
        accuracy = "{0:.2%}". format(test_accuracy)
        #plt.show() 
        path='/var/www/html/scripts/python/TSLA/'
        
        fig=plt.gcf()
        fig.savefig(path+'CNN/display/tsla_sim_'+str(days)+'.png', bbox_inches='tight',dpi=None, facecolor='w', edgecolor='w',
        orientation='portrait', papertype=None, format=None,
        transparent=False, pad_inches=0.1,
        frameon=None)
        #plt.show()    
        
        print '<h2>TSLA Daily Close: Past '+str(days)+' Days</h2>'
        print '<img src=\"scripts/python/TSLA/CNN/display/tsla_sim_'+str(days)+'.png\" onload=\"hideyoyo()\" >'
        
            
    def Test_adv_data(self, training_data, epochs, mini_batch_size, eta,
            validation_data, test_data, labels, alpha, lmbda=0.0):
               
        """        
        init_layer = self.layers[0]
        init_layer.set_inpt(self.x, self.x, self.mini_batch_size)
        for j in range(1, len(self.layers)):
            prev_layer, layer  = self.layers[j-1], self.layers[j]
            layer.set_inpt(
                prev_layer.output, prev_layer.output_dropout, self.mini_batch_size)
        self.output = self.layers[-1].output
        self.output_dropout = self.layers[-1].output_dropout
        """
        
        
        
        """Train the network using mini-batch stochastic gradient descent."""
        training_x, training_y = training_data
        validation_x, validation_y = validation_data
        test_x, test_y = test_data
        
        
        
        #self.LoadParams()
        #print self.params

        # compute number of minibatches for training, validation and testing
        num_training_batches = int (size(training_data)/mini_batch_size )
        num_validation_batches = int (size(validation_data)/mini_batch_size)
        num_test_batches = int (size(test_data)/mini_batch_size)

        
        i = T.lscalar() # mini-batch index
        validate_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                validation_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                validation_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        test_mb_accuracy = theano.function(
            [i], self.layers[-1].accuracy(self.y),
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size],
                self.y:
                test_y[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        self.test_mb_predictions = theano.function(
            [i], self.layers[-1].y_out,
            givens={
                self.x:
                test_x[i*self.mini_batch_size: (i+1)*self.mini_batch_size]
            })
        # Do Test
        print "Test data size: " + str(size(test_data))
        test_accuracy = np.mean([test_mb_accuracy(j) for j in range(num_test_batches)])
        
        correct = 0
        for j in range(num_test_batches):
            #print self.test_mb_predictions(j), labels[j]
            if self.test_mb_predictions(j) == 10:
                correct += 1
            if self.test_mb_predictions(j) == labels[j]:
                correct += 1
            
        untargetted_success = 1.0 - (correct / float(len(labels)))
        print 'correct: ' + str(correct)
        print 'size: ' + str(len(labels))
        print('untargettted success rate: ' + str(untargetted_success))
            
        print('The corresponding test accuracy is {0:.2%}'.format(test_accuracy))
        accuracy = "{0:.2%}". format(test_accuracy)
        
        fout = open('untargetted.txt','a')
        fout.write("Untargeted success rate: " + str(untargetted_success) + " alpha: " + str(alpha) + "\n")
        fout.close()
        
        fout = open('targetted.txt','a')
        fout.write("Targeted success rate: " + str(test_accuracy) + " alpha: " + str(alpha) + "\n")
        fout.close()
        
    def print_stats(self,adv,attack_method,accuracy):
        
        L2=[]
        Linf=[]
        L0=[]
        
        trials = len(adv)
        print "trials: " + str(trials)
        success = 0
        
        for i in range(0,len(adv)):
            
            
            if adv[i][0][1] == adv[i][0][2] or adv[i][0][2] == 9999:
                continue
            
            L2.append(adv[i][1][0])
            Linf.append(adv[i][1][1])
            L0.append(adv[i][1][2])
            
            success += 1
        print "successes: " + str (success)
   
        L2 = np.array(L2)
        Linf = np.array(Linf)
        L0 = np.array(L0)
            
        L2_median = np.median(L2)
        Linf_median = np.median(Linf)
        L0_median = np.median(L0)
        
        file=open('out.txt','a')
        file.write("NNet Accuracy: "+str(accuracy)+"\n")
        file.write("-----"+attack_method+"-----"+"\n")
        file.write("Success rate: " + str( success / float(trials)  )+"\n")
        file.write("Median distortion: L2: " + str(L2_median) + " Linf: " + str(Linf_median) + " L0: " + str(L0_median)+"\n")
        file.close()
        
        print "-----"+attack_method+"-----"
        print "Success rate: " + str( success / float(trials)  )
        print "Median distortion: L2: " + str(L2_median) + " Linf: " + str(Linf_median) + " L0: " + str(L0_median)
        
    def filter_images(self,datax,images,org,tar):   
        
        #print org
        #print tar
            
        #if org == 7 and tar == 0:
                #images['7:0']=datax
                #self.printImage(datax)
        if org == 0 and tar == 1:
                images['0:1']=datax
        if org == 1 and tar == 2:
                images['1:2']=datax
        if org == 2 and tar == 3:
                images['2:3']=datax
        if org == 3 and tar == 4:
                images['3:4']=datax
        if org == 4 and tar == 5:
                images['4:5']=datax
        if org == 5 and tar == 6:
                images['5:6']=datax
        if org == 6 and tar == 7:
                images['6:7']=datax
        if org == 7 and tar == 8:
                images['7:8']=datax
        if org == 8 and tar == 9:
                images['8:9']=datax
        if org == 9 and tar == 0:
                images['9:0']=datax
        
    def attack_iter(self, test_x, test_y, accuracy,n,alpha):
        
        k=10
        
        x_attack = T.matrix("x_attack")
        y_attack = T.ivector("y_attack")
        xp = T.matrix("x_p")
        
        layer2out = self.re_init_net(x_attack, y_attack, xp)
        """
        #-----------------------------By Pixel Attack------------------------
        dlist=[]
        images={}
        #n = len(test_x.get_value())
        
        for i in range(0,n):
            for j in range(0,k):
                
                ax, datax, orig_class, target_class, d_L2, d_Linf, d_L0  = self.attack_byPixel(test_x,test_y,i,j,.01,i)
                #images = [ax, datax]
                #--------------filter images--------------
                self.filter_images(datax,images,orig_class,target_class)
                classes = [i, orig_class, target_class]
                dist = [d_L2, d_Linf, d_L0]
                list = [classes,dist]
                dlist.append(list)
                
        self.print_stats(dlist,'by_Pixel', accuracy)
         
        with open(accuracy + 'by_Pixel_examples_deep.p','wb') as fp:
            cPickle.dump(dlist,fp)
        with open(accuracy + 'by_Pixel_images_deep.p','wb') as fp:
            cPickle.dump(images,fp)
        
        #-----------------------------My Attack------------------------
        dlist=[]
        images={}
        #n = len(test_x.get_value())
        
        for i in range(0,n):
            for j in range(0,k):
                
                #ax, datax, orig_class, target_class, d = self.attack(test_x,test_y,i,j,.01,i)
                ax, datax, orig_class, target_class, d_L2, d_Linf, d_L0  = self.attack(test_x,test_y,i,j,.1,i,'MY_ATTACK')
                #images = [ax, datax]
                #--------------filter images--------------
                self.filter_images(datax,images,orig_class,target_class)
                classes = [i, orig_class, target_class]
                dist = [d_L2, d_Linf, d_L0]
                list = [classes,dist]
                dlist.append(list)
        
        self.print_stats(dlist,'My_Attack', accuracy)
        
        with open(accuracy + 'MY_ATTACK_examples_deep.p','wb') as fp:
            cPickle.dump(dlist,fp)
        with open(accuracy + 'My_ATTACK_images_deep.p','wb') as fp:
            cPickle.dump(images,fp)
        
        #-----------------------------FGSM Attack------------------------
        dlist=[]
        images={}
        #n = len(test_x.get_value())
        
        for i in range(0,n):
            for j in range(0,k):
                
                #ax, datax, orig_class, target_class, d = self.attack(test_x,test_y,i,j,.01,i)
                ax, datax, orig_class, target_class, d_L2, d_Linf, d_L0  = self.attack(test_x,test_y,i,j,.01,i,'FGSM')
                #images = [ax, datax]
                #--------------filter images--------------
                self.filter_images(datax,images,orig_class,target_class)
                classes = [i, orig_class, target_class]
                dist = [d_L2, d_Linf, d_L0]
                list = [classes,dist]
                dlist.append(list)
        
        self.print_stats(dlist,'FGSM', accuracy)
        
        with open(accuracy + 'FGSM_examples_deep.p','wb') as fp:
            cPickle.dump(dlist,fp)
        with open(accuracy + 'FGSM_images_deep.p','wb') as fp:
            cPickle.dump(images,fp)
        """    
        #-----------------------------IGSM Attack------------------------
        
        dlist=[]
        images={}
        #n = len(test_x.get_value())
        
        
        examples=''
        labels=[]
        flag = 0
        n=100
        total = 0
        #alpha = .1
        
        for i in range(0,n):
            
            
            if len(labels) >= 100:
                break
            total += 1
            #for j in range(0,k):
                
                
            orig_class = test_y[i]
            orig_class = orig_class.eval()
            while(True):
                rand = random.randint(0,9)
                if rand != orig_class:
                    break
            print 'alpa: ' + str(alpha)
            #ax, datax, orig_class, target_class, d = self.attack(test_x,test_y,i,j,.01,i)
            ax, datax, target_class, d_L2, d_Linf, d_L0  = self.attack(test_x,test_y,i,orig_class,rand,alpha,i,'IGSM',layer2out,x_attack, y_attack, xp)
            #ax, datax, target_class, d_L2, d_Linf, d_L0 = self.attack_byPixel(test_x,test_y,i,orig_class,9,.01,i)
            #images = [ax, datax]
            #--------------filter images--------------
            #self.filter_images(datax,images,orig_class,target_class)
            """
            classes = [i, orig_class, target_class]
            dist = [d_L2, d_Linf, d_L0]
            list = [classes,dist]
            dlist.append(list)
            """    
            #-------------- save original training images and new adv_examples in list -----------#
            
            print "Successes: " + str(len(labels))
                
            if target_class == 9999 or target_class == orig_class:
                continue
                
            print len(labels)
             
            ex = datax.reshape((784,))
            if flag == 0:
                examples = np.copy(ex)
            else:
                examples = np.vstack((examples,ex))
            label = rand #(targeted) classify adversarial examples as original class or padded class
            #label = orig_class #(non-targeted) classify adversarial examples as original class or padded class
            labels.append(label)
            flag = 1
             
                
            #ax = ax.reshape((784,))
            #examples = np.copy(ax)
            #examples = np.vstack((examples,ax))
            #label = orig_class
            #labels.append(label)
            
            #self.printImage(ax)
            #self.printImage(datax)
                
        
            #----------------Write adv_examples to disk----------#  
        
        print "White box success rate: " + str (len(labels) / float(total))
        fout = open('whitebox_attack_out.txt','a')
        fout.write("White box success rate: " + str (len(labels) / float(total)) + " alpha: " + str(alpha) + "\n")
        fout.close()
        #examples = np.asarray(examples)
        size_labels = len(labels)
        labels = np.asarray(labels)
        labels = labels.reshape((size_labels,))
        
        
        adv_examples=(examples,labels)
        #fw = open("/home/abarton/NetBeansProjects/NNet_onevsall/src/adv_examples/FGSM_"+str(alpha)+".pkl",'wb')
        #cPickle.dump(adv_examples,fw)
        #fw.close()
        
        #print examples.shape
        #print labels.shape
        
        return adv_examples
        
        
        #----------------Write stats to disk---------------#
        #self.print_stats(dlist,'FGSM', accuracy)
        #with open('results/'+ accuracy + 'IGSM_examples_deep.p','wb') as fp:
            #cPickle.dump(dlist,fp)
        #with open('results/'+ accuracy + 'IGSM_images_deep.p','wb') as fp:
            #cPickle.dump(images,fp)
            
        """
            
        #-----------------------------Generate Adv Examples------------------------
        
        dlist=[]
        images={}
        #n = len(test_x.get_value())
        
        
        examples=''
        labels=[]
   
        #n=5
        for i in range(0,n):
            
            #if len(labels) >= 100:
                #break
            
            #for j in range(0,k):
                
                
                orig_class = test_y[i]
                orig_class = orig_class.eval()
                while(True):
                    rand = random.randint(0,9)
                    if rand != orig_class:
                        break
                        
                alphas = [0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0]
                ralph = random.randint(0,9)
                alpha = alphas[ralph]
                print 'alpa: ' + str(alpha)
                #ax, datax, orig_class, target_class, d = self.attack(test_x,test_y,i,j,.01,i)
                ax, datax, target_class, d_L2, d_Linf, d_L0  = self.attack(test_x,test_y,i,orig_class,rand,alpha,i,'IGSM')
                #ax, datax, target_class, d_L2, d_Linf, d_L0 = self.attack_byPixel(test_x,test_y,i,orig_class,9,.01,i)
                #images = [ax, datax]
                #--------------filter images--------------
                #self.filter_images(datax,images,orig_class,target_class)
                classes = [i, orig_class, target_class]
                dist = [d_L2, d_Linf, d_L0]
                list = [classes,dist]
                dlist.append(list)
                
                #-------------- save original training images and new adv_examples in list -----------#
                
                
                
                if target_class == 9999:# or target_class == orig_class:
                    continue
                
                #print len(labels)
                
                ex = datax.reshape((784,))
                if i == 0:
                    examples = np.copy(ex)
                else:
                    examples = np.vstack((examples,ex))
                label = 10 #classify adversarial examples as original class or padded class
                labels.append(label)
                
                ax = ax.reshape((784,))
                examples = np.vstack((examples,ax))
                label = orig_class
                labels.append(label)
                
                
                
                
                
                #self.printImage(ax)
                #self.printImage(datax)
                
        
                #----------------Write adv_examples to disk----------#  
        
        
        #examples = np.asarray(examples)
        size_labels = len(labels)
        labels = np.asarray(labels)
        labels = labels.reshape((size_labels,))
        
        
        adv_examples=(examples,labels)
        fw = open("/home/abarton/NetBeansProjects/NNet_onevsall/src/adv_examples/training_data_with_IGSM_examples.pkl",'wb')
        cPickle.dump(adv_examples,fw)
        fw.close()
        
        print examples.shape
        print labels.shape
        
        
        
        
        #----------------Write stats to disk---------------#
        #self.print_stats(dlist,'FGSM', accuracy)
        #with open('results/'+ accuracy + 'IGSM_examples_deep.p','wb') as fp:
            #cPickle.dump(dlist,fp)
        #with open('results/'+ accuracy + 'IGSM_images_deep.p','wb') as fp:
            #cPickle.dump(images,fp)        
        """    
    
            
    def printImage(self,datax):
        h, w = 28, 28    
        datax.resize((h,w))
        img = Image.fromarray((datax+0.5)*255)
    
        #print data
        
        img.show()
        #img.convert('RGB')
        #img.save('images/'+attack+'_'+str(org)+"_"+str(tar)+".jpeg")
        
    
    def re_init_net(self,x_attack, y_attack, xp):
        
        init_layer = self.layers[0]
        #init_layer.image_shape = (1,1,28,28)
        #self.layers[1].image_shape = (1,32,26,26)
        #self.layers[2].image_shape = (1,32,12,12)
        #self.layers[3].image_shape = (1,64,10,10)
        init_layer.set_inpt(x_attack, x_attack, 1)
        for j in xrange(1, len(self.layers)):
            prev_layer, layer  = self.layers[j-1], self.layers[j]
            layer.set_inpt(prev_layer.output, prev_layer.output_dropout, 1)
            
        layer2out = self.layers[-1].output
        
        return layer2out
        
    def attack(self,test_x,test_y,orig,orig_class,target, eta, itr,attack_method,layer2out,x_attack, y_attack, xp):
        
        dict={}
        
        print ('attack: ' + str(orig))
        
        
        datax = test_x.get_value()[orig].reshape(784,1) #test_x is a matrix.  data is a np vector
        ax = test_x.get_value()[orig].reshape(784,1)
        datay = np.array([target],dtype=np.dtype(np.int32))
        shared_x = theano.shared( np.asarray(datax, dtype=theano.config.floatX),  borrow=True)# shared vector
        
        
        
        
        
        
        
        
        #c = 2.75
        #cost =    ((xp - x_attack)**2).sum()  + c * (-T.mean(T.log(layer2out)[T.arange(y_attack.shape[0]), y_attack]) )
        cost = -T.mean(T.log(layer2out)[T.arange(y_attack.shape[0]), y_attack]) 
        grads = T.grad(cost, x_attack)
        
        #updates = [(shared_x, shared_x-eta*grads)] #my attack
        #updates = [(shared_x, shared_x-.007*(.01*T.sin(grads)))] #Fast Grad Sign attack
        
        if attack_method == 'MY_ATTACK':
            #updates = [(shared_x, shared_x-T.clip(.01*(grads**3),-.007,.007  ))] #my attack
            #updates = [(shared_x, shared_x-.005*(grads**3))]
            #updates = [(shared_x, T.clip(    shared_x-    .005* ( 2000*(grads**3)+ .3*(grads) )      ,datax-.17,datax+.17  ))]
            #updates = [(shared_x,    shared_x-T.clip(    .001* ( 3000*(grads**3)+ .3*(grads) ) ,-.007,.007   )  )]
            updates = [(shared_x,    T.clip(shared_x-T.clip(    ( 4000*(grads**3) ) ,-.007,.007   ), datax-.25,datax+.25 )       )]
        
        if attack_method == 'FGSM':
            updates = [(shared_x, shared_x-(eta*T.sgn(grads)))] #Fast Grad Sign attack, takes one single step toward the gradiant
        
        if attack_method == 'IGSM':
            #clip = .007 #I got this clip value from the paper
            #updates = [(shared_x, shared_x-T.clip( (.01*T.sgn(grads)),-.007,.007   ))] #Iterative Grad Sign attack.
            updates = [(shared_x, T.clip( shared_x-(.007*T.sgn(grads)),datax-eta,datax+eta   ))]
            #updates = [(shared_x,  shared_x-(.007*T.sgn(grads)))]

        run_attack = theano.function(
            [x_attack,y_attack], cost, updates=updates,
            )
        #######################For Printing Gradiant vector###########################
        comp_cost = theano.function(
            [x_attack,y_attack], cost
            )
        comp_grad = theano.function(
        [cost,x_attack,y_attack],grads
        )
        ########################################################################
            
        y_out = T.argmax(layer2out, axis=1)
        
        out = theano.function(
            [x_attack], y_out
            )
            
        dist = T.sqrt( ((xp - x_attack)**2).sum() )
        #dist = T.sum(  T.sqrt(T.dot(x_attack, T.transpose(x_attack)) - 2 * T.dot(x_attack, T.transpose(xp)) + T.dot(xp, T.transpose(xp))) )
        
        calc_dist = theano.function(
            [x_attack, xp], dist
            )
        
        #orig_class = out(datax)
        
        print ("original class:" + str(orig_class))
        
        count = 0
        while True:
            
            ##########################For Printing Gradiant#################
            ccost = comp_cost(datax,datay)
            gradiant = comp_grad(ccost,datax,datay)
            #print gradiant
            ################################################################
            
            cost = run_attack(datax,datay)
            count += 1
            #a1 = np.array(datax,dtype=np.dtype(np.float32)).reshape(784,1)
            #a2 = np.array(shared_x.get_value(),dtype=np.dtype(np.float32)).reshape(784,1)
            
            #-------------L2 Distance-------------
            d_L2 = calc_dist(ax,datax)
            
            #-------------Linf Distance-----------
            diff = ax - datax
            diffi = np.argmax(diff)
            d_Linf = diff[diffi]
            
            #------------L0 Distance-------------
            dcount = 0
            for e in diff:
                if e != 0:
                    dcount += 1
            d_L0 = dcount
            
            print ("cnt: " + str(count) + " cost: " + str(cost) + " prediction: " + str(out(datax)))
            
            target_class = out(datax)
            if orig_class == 10:
                break
            if target_class == target: #targeted attack
            #if target_class != orig_class and target_class != 10:  #non-targeted attack
                
                print ("target class: " + str(target) + " L2: " + str(d_L2) + " Linf: " + str(d_Linf) + " L0: " + str(d_L0) )
                #if d_Linf > .3:
                #self.printImage(datax)
                break
                
            if count == 300:
                target_class = 9999
                print ("target class: FAILED")
                break
                
            if attack_method == 'FGSM' or attack_method == 'MY_ATTACK':
                if target_class != target:
                    target_class = 9999
                    
                break  #used for taking one single step toward the gradiant (FGSM)
                
            
                
                
        #self.printImage(datax)        
        return ax, datax, target_class, d_L2, d_Linf, d_L0      
        
        
        
    def attack_byPixel(self,test_x,test_y,orig,orig_class,target, eta, itr):
        
        dict={}
        
        print ('attack: ' + str(itr))
        
        
        datax = test_x.get_value()[orig].reshape(784,1) #test_x is a matrix.  data is a np vector
        ax = test_x.get_value()[orig].reshape(784,1)
        datay = np.array([target],dtype=np.dtype(np.int32))
        shared_x = theano.shared( np.asarray(datax, dtype=theano.config.floatX),  borrow=True)# shared vector
        
        x_attack = T.matrix("x_attack")
        y_attack = T.ivector("y_attack")
        xp = T.matrix("x_p")
        
        init_layer = self.layers[0]
        init_layer.image_shape = (1,1,28,28)
        self.layers[1].image_shape = (1,20,12,12)
        init_layer.set_inpt(x_attack, x_attack, 1)
        for j in xrange(1, len(self.layers)):
            prev_layer, layer  = self.layers[j-1], self.layers[j]
            layer.set_inpt(prev_layer.output, prev_layer.output_dropout, 1)
            
        
        
        #layer1 = self.layers[0]
        #layer2 = self.layers[1]
        
        #layer1w = layer1.params[0]
        #layer1b = layer1.params[1]
        
        #layer2w = layer2.params[0]
        #layer2b = layer2.params[1]
        
        #layer1in = x_attack.reshape((1,784))
        #layer1out = sigmoid(T.dot(layer1in, layer1w) + layer1b)
        
        #layer2in = layer1out.reshape((1,1500))
        #layer2out = softmax(T.dot(layer2in, layer2w) + layer2b)
        layer2out = self.layers[-1].output_dropout
        
        #c = 2.75
        #cost =    ((xp - x_attack)**2).sum()  + c * (-T.mean(T.log(layer2out)[T.arange(y_attack.shape[0]), y_attack]) )
        cost = -T.mean(T.log(layer2out)[T.arange(y_attack.shape[0]), y_attack]) 
        grads = T.grad(cost, x_attack)
        
        updates = [(shared_x, shared_x-eta*grads)] #my attack
        #updates = [(shared_x, shared_x-.007*(.01*T.sin(grads)))] #Fast Grad Sign attack

        run_attack = theano.function(
            [x_attack,y_attack], cost
            )
        comp_grad = theano.function(
        [cost,x_attack,y_attack],grads
        )
            
        y_out = T.argmax(layer2out, axis=1)
        
        out = theano.function(
            [x_attack], y_out
            )
            
        dist = T.sqrt( ((xp - x_attack)**2).sum() )
        #dist = T.argmax(x_attack - xp)
        #dist = T.sum(  T.sqrt(T.dot(x_attack, T.transpose(x_attack)) - 2 * T.dot(x_attack, T.transpose(xp)) + T.dot(xp, T.transpose(xp))) )
        
        calc_dist = theano.function(
            [x_attack, xp], dist
            )
        
        #orig_class = out(datax)
        print ("original class:" + str(orig_class))
        
        count = 0
        
        while True:
            cost = run_attack(datax,datay)
            gradiant = comp_grad(cost,datax,datay)
            #gradiant = np.sin(gradiant)
            
            pix = np.argmax(gradiant)
            
            #print gradiant
            datax[pix] = datax[pix] - np.clip(.01*(gradiant[pix]**3),-.007,.007 )
            
            count += 1
            #a1 = np.array(datax,dtype=np.dtype(np.float32)).reshape(784,1)
            #a2 = np.array(shared_x.get_value(),dtype=np.dtype(np.float32)).reshape(784,1)
            
            #-------------L2 Distance-------------
            d_L2 = calc_dist(ax,datax)
            
            #-------------Linf Distance-----------
            diff = ax - datax
            diffi = np.argmax(diff)
            d_Linf = diff[diffi]
            
            #------------L0 Distance-------------
            dcount = 0
            for e in diff:
                if e != 0:
                    dcount += 1
            d_L0 = dcount
            
            #print pix
            #print gradiant[pix]
            #print ("cnt: " + str(count) + " d: " + str(d) + " cost: " + str(cost))
            
            target_class = out(datax)
            
            if target_class == target:
                print ("target class:" + str(out(datax)) + " L2: " + str(d_L2) + " Linf: " + str(d_Linf) + " L0: " + str(d_L0) )
                break
                
            if count == 20000:
                target_class = 9999
                print ("target class: FAILED")
                break
                
        #self.printImage(datax)        
        return ax, datax, target_class, d_L2, d_Linf, d_L0      
        
        
        
        
    
        
        

#### Define layer types

class ConvLayer(object):
    """Used to create a combination of a convolutional and a max-pooling
    layer.  A more sophisticated implementation would separate the
    two, but for our purposes we'll always use them together, and it
    simplifies the code, so it makes sense to combine them.

    """

    def __init__(self, filter_shape, image_shape,
                 activation_fn=sigmoid):
        """`filter_shape` is a tuple of length 4, whose entries are the number
        of filters, the number of input feature maps, the filter height, and the
        filter width.

        `image_shape` is a tuple of length 4, whose entries are the
        mini-batch size, the number of input feature maps, the image
        height, and the image width.

        `poolsize` is a tuple of length 2, whose entries are the y and
        x pooling sizes.

        """
        self.filter_shape = filter_shape
        self.image_shape = image_shape
       
        self.activation_fn=activation_fn
        # initialize weights and biases
        n_out = (filter_shape[0]*np.prod(filter_shape[2:]))
        self.w = theano.shared(
            np.asarray(
                np.random.normal(loc=0, scale=np.sqrt(1.0/n_out), size=filter_shape),
                dtype=theano.config.floatX),
            borrow=True)
        self.b = theano.shared(
            np.asarray(
                np.random.normal(loc=0, scale=1.0, size=(filter_shape[0],)),
                dtype=theano.config.floatX),
            borrow=True)
        self.params = [self.w, self.b]

    def set_inpt(self, inpt, inpt_dropout, mini_batch_size):
        self.inpt = inpt.reshape(self.image_shape)
        conv_out = conv.conv2d(
            input=self.inpt, filters=self.w, filter_shape=self.filter_shape,
            image_shape=self.image_shape)
        self.output = self.activation_fn(
            conv_out + self.b.dimshuffle('x', 0, 'x', 'x'))
        self.output_dropout = self.output # no dropout in the convolutional layers
        
        #print self.b.shape
    

class ConvPoolLayer(object):
    """Used to create a combination of a convolutional and a max-pooling
    layer.  A more sophisticated implementation would separate the
    two, but for our purposes we'll always use them together, and it
    simplifies the code, so it makes sense to combine them.

    """

    def __init__(self, filter_shape, image_shape, poolsize=(2, 2),
                 activation_fn=sigmoid):
        """`filter_shape` is a tuple of length 4, whose entries are the number
        of filters, the number of input feature maps, the filter height, and the
        filter width.

        `image_shape` is a tuple of length 4, whose entries are the
        mini-batch size, the number of input feature maps, the image
        height, and the image width.

        `poolsize` is a tuple of length 2, whose entries are the y and
        x pooling sizes.

        """
        self.filter_shape = filter_shape
        self.image_shape = image_shape
        self.poolsize = poolsize
        self.activation_fn=activation_fn
        # initialize weights and biases
        n_out = (filter_shape[0]*np.prod(filter_shape[2:])/np.prod(poolsize))
        self.w = theano.shared(
            np.asarray(
                np.random.normal(loc=0, scale=np.sqrt(1.0/n_out), size=filter_shape),
                dtype=theano.config.floatX),
            borrow=True)
        self.b = theano.shared(
            np.asarray(
                np.random.normal(loc=0, scale=1.0, size=(filter_shape[0],)),
                dtype=theano.config.floatX),
            borrow=True)
        self.params = [self.w, self.b]

    def set_inpt(self, inpt, inpt_dropout, mini_batch_size):
        #print "here"
        self.inpt = inpt.reshape(self.image_shape)
        conv_out = conv.conv2d(
            input=self.inpt, filters=self.w, filter_shape=self.filter_shape,
            image_shape=self.image_shape)
        pooled_out = pool.pool_2d(
            input=conv_out, ds=self.poolsize, ignore_border=True)
        self.output = self.activation_fn(
            pooled_out + self.b.dimshuffle('x', 0, 'x', 'x'))
        self.output_dropout = self.output # no dropout in the convolutional layers
        
     

class FullyConnectedLayer(object):

    def __init__(self, n_in, n_out, activation_fn=sigmoid, p_dropout=0.0):
        self.n_in = n_in
        self.n_out = n_out
        self.activation_fn = activation_fn
        self.p_dropout = p_dropout
        # Initialize weights and biases
        self.w = theano.shared(
            np.asarray(
                np.random.normal(
                    loc=0.0, scale=np.sqrt(1.0/n_out), size=(n_in, n_out)),
                dtype=theano.config.floatX),
            name='w', borrow=True)
        self.b = theano.shared(
            np.asarray(np.random.normal(loc=0.0, scale=1.0, size=(n_out,)),
                       dtype=theano.config.floatX),
            name='b', borrow=True)
        self.params = [self.w, self.b]

    

    def set_inpt(self, inpt, inpt_dropout, mini_batch_size):
        self.inpt = inpt.reshape((mini_batch_size, self.n_in))
        self.output = self.activation_fn(
            (1-self.p_dropout)*T.dot(self.inpt, self.w) + self.b)
        self.y_out = T.argmax(self.output, axis=1)
        self.inpt_dropout = dropout_layer(
            inpt_dropout.reshape((mini_batch_size, self.n_in)), self.p_dropout)
        self.output_dropout = self.activation_fn(
            T.dot(self.inpt_dropout, self.w) + self.b)

    def accuracy(self, y):
        "Return the accuracy for the mini-batch."
        return T.mean(T.eq(y, self.y_out))

class SoftmaxLayer(object):

    def __init__(self, n_in, n_out, p_dropout=0.0):
        self.n_in = n_in
        self.n_out = n_out
        self.p_dropout = p_dropout
        # Initialize weights and biases
        self.w = theano.shared(
            np.zeros((n_in, n_out), dtype=theano.config.floatX),
            name='w', borrow=True)
        self.b = theano.shared(
            np.zeros((n_out,), dtype=theano.config.floatX),
            name='b', borrow=True)
        self.params = [self.w, self.b]

    def set_inpt(self, inpt, inpt_dropout, mini_batch_size):
        self.inpt = inpt.reshape((mini_batch_size, self.n_in))
        self.output = softmax((1-self.p_dropout)*T.dot(self.inpt, self.w) + self.b)
        self.y_out = T.argmax(self.output, axis=1)
        self.inpt_dropout = dropout_layer(
            inpt_dropout.reshape((mini_batch_size, self.n_in)), self.p_dropout)
        self.output_dropout = softmax(T.dot(self.inpt_dropout, self.w) + self.b)
        self.y_out_dropout = T.argmax(self.output_dropout,axis=1)

    def cost(self, net):
        "Return the log-likelihood cost."
        #print (net.y.shape[0])
    
        return -T.mean(T.log(self.output_dropout)[T.arange(net.y.shape[0]), net.y])
    
    def costAGT(self, net, y):
        "Return the log-likelihood cost."
        datay = np.array([y],dtype=np.dtype(np.int32))
        #quadratic cost function
        #return .5 * T.sum( (self.output - datay)**2 )
        #return .5 * T.sum( (self.output - net.y)**2 ) 
       
        #cross-entropy cost function
        return T.sum( -datay*T.log(self.output_dropout)-(1-datay)*T.log(1-self.output_dropout))
    
        #return T.sum( -net.y*T.log(self.output)-(1-net.y)*T.log(1-self.output))

    def accuracy(self, y):
        "Return the accuracy for the mini-batch."
        return T.mean(T.eq(y, self.y_out))
    
    def accuracy_dropout(self, y):
        "Return the accuracy for the mini-batch."
        return T.mean(T.eq(y, self.y_out_dropout))


#### Miscellanea
def size(data):
    "Return the size of the dataset `data`."
    return data[0].get_value(borrow=True).shape[0]

def dropout_layer(layer, p_dropout):
    srng = shared_randomstreams.RandomStreams(
        np.random.RandomState(0).randint(999999))
    mask = srng.binomial(n=1, p=1-p_dropout, size=layer.shape)
    #print "===============here"
    return layer*T.cast(mask, theano.config.floatX)
