import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "用户关注，取消关注，互粉，用户界面"')
os.system('git push')
os.system('pause')
