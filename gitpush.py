import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "邮件验证，注册，登录，重置密码"')
os.system('git push')
os.system('pause')
