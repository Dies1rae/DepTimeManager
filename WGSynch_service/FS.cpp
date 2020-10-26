#include "FS.h"
using namespace std;

FS::FS() :all_users_base(), main_settings_(), settings_file_path_(".\\settings.ini"s) {
	main_settings_.init_settings(this ->settings_file_path_);
}

FS::FS(const std::string & settings_file_path):all_users_base(), main_settings_(), settings_file_path_(settings_file_path){
	main_settings_.init_settings(this->settings_file_path_);
}

void FS::main_loop() {
	this->sql_update_db();
	std::cout << "ALL OK!"s << std::endl;
}

