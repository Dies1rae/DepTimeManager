#include <iostream>
#include <mysql.h>
#include "FS.h"
#include <windows.h>
#include <algorithm>

using namespace std::string_literals;


std::vector<std::string> init_settings(std::string settings_file_path = ".\\settings.ini"s) {
	std::vector<std::string> settings_string;
	std::ifstream settings_file(settings_file_path, std::ios::binary);
	std::string tmp_sett;

	if (settings_file.is_open()) {
		while (std::getline(settings_file, tmp_sett)) {
			settings_string.push_back(tmp_sett);
		}
		settings_file.close();
	}

	settings_string.erase(remove_if(settings_string.begin(), settings_string.end(), [](std::string& A) {
		if (A.find("[DBSETTINGS]"s) != std::string::npos || A.find("[INFOFILE]"s) != std::string::npos) {
			return 1;
		} else {
			return 0;
		}
		}), settings_string.end());
	return settings_string;
}


int main(int argc, char* argv[]) {
	SetConsoleCP(1251);
	SetConsoleOutputCP(1251);
	
	if (argc > 1 && argv[1][0] == '/') {
		if (argv[1][1] == 'p') {
			FS fs_main(init_settings(argv[2]), argv[2]);
			fs_main.main_loop();
		}
	} else {
		FS fs_main(init_settings());
		fs_main.main_loop();
	}
	return 0;
}