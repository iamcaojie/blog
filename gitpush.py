import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "无限级分类显示和添加"')
os.system('git push')
os.system('pause')
