set projectGit=https://github.com/nimestel/todo-codecept.git
set projectDir=todo-codecept

:: клонируем проект
git clone %projectGit% %projectDir%
cd %projectDir%
call git pull origin

:: разворачиваем пакеты зависимостей
call composer install

