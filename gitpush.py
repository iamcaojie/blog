import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "优化blog模型，关联标签和分类"')
os.system('git push')
os.system('pause')
