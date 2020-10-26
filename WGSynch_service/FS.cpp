#include "FS.h"
using namespace std;

FS::FS(const std::vector<std::string>& settings) :all_users_base(), settings_file_path_(".\\settings.ini"s) {
	this->db_address_ = settings[0].c_str();
	this->db_port_ = std::stoi(settings[1]);
	this->db_name_ = settings[2].c_str();
	this->db_login_ = settings[3].c_str();
	this->db_password_ = settings[4].c_str();
	this->infofile_path_ = settings[5].c_str();
}

FS::FS(const std::vector<std::string>& settings, const std::string & settings_file_path):all_users_base(), settings_file_path_(settings_file_path){
	this->db_address_ = settings[0].c_str();
	this->db_port_ = std::stoi(settings[1]);
	this->db_name_ = settings[2].c_str();
	this->db_login_ = settings[3].c_str();
	this->db_password_ = settings[4].c_str();
	this->infofile_path_ = settings[5].c_str();
}

void FS::main_loop() {
	
	this->sql_update_db();
	std::cout << "ALL OK!"s << std::endl;
}

