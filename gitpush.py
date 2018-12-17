import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "后台标签动态生成"')
os.system('git push')
os.system('pause')
