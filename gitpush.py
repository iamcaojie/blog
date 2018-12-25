import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "优化评论页，管理标签增加和修改功能"')
os.system('git push')
os.system('pause')
