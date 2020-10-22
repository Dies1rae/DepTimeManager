#include <iostream>
#include <mysql.h>
#include "FS.h"
#include <windows.h>

int main(int argc, char* argv[]) {
	SetConsoleCP(1251);
	SetConsoleOutputCP(1251);

	FS fs_main;
	fs_main.init_settings();
	std::cout << std::endl;
	fs_main.init_all_users_base();

	return 0;
}