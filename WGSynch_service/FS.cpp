#include "FS.h"
using namespace std::string_literals;

FS::FS(): settings_file_path_(".\\settings.ini"s) {}
FS::FS(const std::string & settings_file_path): settings_file_path_(settings_file_path) {}



void FS::main_loop() {
	this->init_settings();
	std::cout << "Init settings OK!"s << std::endl;
	this->init_all_users_base();
	std::cout << "Read infofile OK!"s << std::endl;
	this->sql_load_data();
	std::cout << "Upload data to MYSQL DB OK!"s << std::endl;
}

