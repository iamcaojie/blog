import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "后台链接展示，修改，升级tp核心"')
os.system('git push')
os.system('pause')
