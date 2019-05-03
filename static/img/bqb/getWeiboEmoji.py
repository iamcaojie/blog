import requests as r
import os
url = 'https://api.weibo.com/2/emotions.json?source=1362404091'

res  = r.get(url) 
res.encoding = 'utf-8'
res = res.json()
n = 1
address = os.path.abspath(os.path.dirname(__file__))
os.chdir(address)
if(not os.path.exists(address+'/w2')):
    os.makedirs(address+'/w2') 

for re in res:
    print('下载第'+str(n)+'张图片')
    image_data = r.get(re['url']) 
    with open('weibo/'+str(n)+'.png',"wb") as image_object:
        for chunk in image_data:
            image_object.write(chunk)
    n+=1
    