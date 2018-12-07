import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "网站状态开关，优化后台样式"')
os.system('git push')
os.system('pause')
