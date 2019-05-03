import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "用户收藏，新增，编辑文章，编辑器支持表情包，详情页展示作者，修改db模块为安装程序"')
os.system('git push')
os.system('pause')
