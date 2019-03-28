import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "重写首页"')
os.system('git push')
os.system('pause')
