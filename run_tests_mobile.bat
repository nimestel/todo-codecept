set outputDir=tests/_output

:: очистка каталога _output
call codecept clean

:: запуск тестов для mobile в firefox и chrome
call codecept run acceptance --env mobile,chrome --env mobile,firefox -g mobile --html

:: открытие отчета
cd %outputDir%
call report.html