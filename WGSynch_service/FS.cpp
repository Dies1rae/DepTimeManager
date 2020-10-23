#include "FS.h"
using namespace std::string_literals;

FS::FS(): settings_file_path_(".\\settings.ini"s) {}
FS::FS(const std::string & settings_file_path): settings_file_path_(settings_file_path) {}



void FS::main_loop() {
	this->main_settings_.init_settings(this->settings_file_path_);
	std::cout << "Init settings OK!"s << std::endl;
	this->sql_update_db();
	std::cout << "ALL OK!"s << std::endl;
}

