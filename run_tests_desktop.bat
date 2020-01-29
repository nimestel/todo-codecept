set outputDir=tests/_output

:: очистка каталога _output
call codecept clean

:: запуск тестов для ПК в firefox и chrome
call codecept run acceptance --env desktop,chrome --env desktop,firefox -g desktop --html

:: открытие отчета
cd %outputDir%
call report.html