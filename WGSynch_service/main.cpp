#include <iostream>
#include <mysql.h>
#include "FS.h"
#include <windows.h>
using namespace std::string_literals;


int main(int argc, char* argv[]) {
	SetConsoleCP(1251);
	SetConsoleOutputCP(1251);
	
	if (argc > 1 && argv[1][0] == '/') {
		if (argv[1][1] == 'p') {
			FS fs_main(argv[2]);
			fs_main.init_settings();
			std::cout << std::endl;
			fs_main.init_all_users_base();
		}
	} else {
		FS fs_main;
		fs_main.main_loop();
	}

	std::cout << "TEST SERVICE - OK"s << std::endl;
	return 0;
}