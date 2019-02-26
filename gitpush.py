import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "轮播图片上传，普通用户界面"')
os.system('git push')
os.system('pause')
