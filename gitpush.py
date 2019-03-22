import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "基本完善权限，用户组，用户的增删改查"')
os.system('git push')
os.system('pause')
