#include <iostream>
#include <mysql.h>
#include "FS.h"
#include "logg.h"
#include <windows.h>
#include <algorithm>

using namespace std::string_literals;



int main(int argc, char* argv[]) {
	SetConsoleCP(1251);
	SetConsoleOutputCP(1251);

	logg* mainLog = new logg();
	mainLog->add_log_string_timemark_("SVC STARTING"s);
	mainLog->add_log_string("");

	if (argc > 1 && argv[1][0] == '/') {
		if (argv[1][1] == 'p') {
			FS fs_main(mainLog, argv[2]);
			fs_main.main_loop();
		}
	} else {
		FS fs_main(mainLog);
		fs_main.main_loop();
	}

	mainLog->add_log_string("");
	mainLog->add_log_string_timemark_("SVC DONE"s);
	mainLog->write_to_file();
	return 0;
}