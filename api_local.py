# Using flask to make an api
# import necessary libraries and functions
from flask import Flask, jsonify, request
import time
import logging
from datetime import datetime
import joblib
from sklearn import preprocessing
from sklearn.preprocessing import MinMaxScaler
from sklearn.preprocessing import StandardScaler
import pandas as pd
import numpy as np
import os
import json

dir_path = os.path.dirname(os.path.realpath(__file__))

model_teh_classification = dir_path+'/model/e-nose_tea_classification_model.sav'
global classifier
classifier_teh = joblib.load(model_teh_classification)

model_teh_regression = dir_path+'/model/e-nose_tea_regression_model.sav'
global regressor
regressor_teh = joblib.load(model_teh_regression)

scaler_teh = dir_path+'/model/scaler_teh.sav'
scaler_teh = joblib.load(scaler_teh)


def getLabel(x):
    if(x==0):
        res='Baik'
    else:
        res='Cacat Mutu'
    return res

def sinkronisasi_scr(kelas, score):
    if kelas=='Baik':
        if score > 45.3:
            score = [45.3]
    elif kelas=='Cacat Mutu':
        if  score <= 40.4:
            score = [45.3]
    return score

# creating a Flask app
app = Flask(__name__)
  
# on the terminal type: curl http://127.0.0.1:5000/
# returns hello world when we use GET.
# returns the data that we send when we use POST.
@app.route('/', methods = ['GET', 'POST'])
def home():
 if(request.method == 'GET'):
  
        data = "Welcome to electronic nose API"
        return jsonify({'data': data})
  
  
# A simple function to calculate the square of a number
# the number to be squared is sent in the URL when we use GET
# on the terminal type: curl http://127.0.0.1:5000 / home / 10
# this returns 100 (square of 10)
@app.route('/home/<int:num>', methods = ['GET'])
def disp(num):
    return jsonify({'data': num**2})
  

@app.route('/enose_tea', methods=['POST'])
def process_json():
    content_type = request.headers.get('Content-Type')
    print(content_type)
    if (content_type == 'application/json'):
        json_req = request.json
        print(json_req)
        data=[]
        for i in json_req['data']:
            data.append(i)
          
        #print(data)  
        df = pd.DataFrame(data, columns = ['MQ3', 'TGS822', 'TGS2602', 'MQ5', 'MQ138', 'TGS2620'])

        print(df)
        features = scaler_teh.transform(df)
        print(features)
        hasil = pd.DataFrame(columns = ['Label', 'Score'])
        for feat in features:
            feat = np.array([feat])
            #print(feat)
            teh_Label = getLabel(classifier_teh.predict(feat))
            scr = regressor_teh.predict(feat)
            #tvc = tvc[0]
            print(classifier_teh.predict(feat))
            new_row = {'Label':teh_Label,'Score':scr[0]}
            print(teh_Label,scr)
            #new_row = {'Label':seafood_Label}
            hasil = hasil.append(new_row,ignore_index=True)
        #json_rep = {'Label':seafood_Label,'tvc':tvc}
        json_rep = hasil.to_json(orient='index')
        print(json_rep)
        return json_rep
    else:
        return 'Content-Type not supported!'
  
# driver function
if __name__ == '_main_':
    #website_url = '10.251.251.169:8080'
    website_url = 'localhost:8080'
    app.config['SERVER_NAME'] = website_url
app.run()