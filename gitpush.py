import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "评论限制，提交评论功能，显示评论功能"')
os.system('git push')
os.system('pause')
