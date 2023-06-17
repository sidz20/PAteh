#Praktikum
import requests
import json
import pandas as pd
endpoint = 'http://127.0.0.1:5000/enose_tea'
#data yang dikirim 
x_new = [
    [855, 304, 299, 417, 810, 349],
    [837, 299, 297, 417, 893, 347],
    [806, 297, 304, 417, 911, 346], 

]

input_json = json.dumps({"data": x_new})
print(input_json)

# Set the content type
headers = {'Content-Type':'application/json'}

predictions = requests.post(endpoint, input_json, headers = headers)
if predictions.ok:
    hasil = predictions.json()
    df_hasil = pd.DataFrame.from_dict(hasil,   orient="index")
    print('Tabel hasil:')
    print(df_hasil)
    df_hasil.to_excel('hasil_prediksi_endpoint.xlsx')
else:
    print('gagal')
