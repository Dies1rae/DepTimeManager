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
	logg* main = new logg();

	if (argc > 1 && argv[1][0] == '/') {
		if (argv[1][1] == 'p') {
			FS fs_main(main, argv[2]);
			fs_main.main_loop();
		}
	} else {
		FS fs_main(main);
		fs_main.main_loop();
	}
	return 0;
}