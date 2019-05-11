import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "性能优化,静态文件CDN,压缩图片,页面优化"')
os.system('git push')
os.system('pause')
