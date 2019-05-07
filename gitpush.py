import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "文章，标签，用户搜索"')
os.system('git push')
os.system('pause')
