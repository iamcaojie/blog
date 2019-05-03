# 生成wangEditor所需表情地址的数组文件
"""
[
    {title: '默认', type: 'image',
        content: [
            {
                art:''
                src: '/static/img/bqb/e/1.png'
            },
            ...
        ]
    },
    ...
    ];
"""
import os
import json
address = os.path.abspath(os.path.dirname(__file__))
os.chdir(address)
dirlist = os.listdir(address)
array = [];
# name = {'e':'emoji','e2':'emoji2017','m':'脉脉','q1':'新版QQ','q2':'旧版QQ','t':'贴吧','w1':'新版微博','w2':'旧版微博','w3':'微博跪了'}
print(dirlist)
# 遍历文件夹
for dir in dirlist:
    newdir = address+'\\'+dir
    sarray = {}
    if(os.path.isdir(newdir)):
        dirlist2 = os.listdir(newdir)
        dirlist2 = sorted(dirlist2,key= lambda x:int(x[:-4]))
        sarray['title'] = dir
        sarray['type'] = 'image'
        # 遍历文件夹下的文件
        content = []
        for dir2 in dirlist2:
            newdir2 = newdir+'\\'+dir2
            if(os.path.isfile(newdir2)):
                eaddress = {'alt':dir2,'src':'/static/img/bqb/'+dir+'/'+dir2}
                content.append(eaddress)
        sarray['content'] = content
        array.append(sarray)
print(array)
with open('emoji.json','w') as file_object:
    file_object.write(str(array).replace("'",'"'))

                