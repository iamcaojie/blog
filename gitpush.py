import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "轮播，文字主图，详情图上传"')
os.system('git push')
os.system('pause')
