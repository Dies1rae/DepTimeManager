#include "FS.h"
using namespace std::string_literals;

FS::FS(): settings_file_path_(".\\settings.ini"s) {}
FS::FS(const std::string & settings_file_path): settings_file_path_(settings_file_path) {}

void FS::init_settings() {
	std::vector<std::string> settings_string;
	std::ifstream settings_file(this->settings_file_path_, std::ios::binary);
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
	this->main_settings_.set_db_address(settings_string[0]);
	this->main_settings_.set_db_port(settings_string[1]);
	this->main_settings_.set_db_name(settings_string[2]);
	this->main_settings_.set_db_login(settings_string[3]);
	this->main_settings_.set_db_password(settings_string[4]);
	this->main_settings_.set_infofile_path(settings_string[5]);

}

void FS::init_all_users_base() {
	std::ifstream user_infofile(this->main_settings_.get_infofile_path(), std::ios::binary);
	std::vector<std::string> tmp_usersinfo(8);

	if (user_infofile.is_open()) {
		while (user_infofile.good()) {
			std::getline(user_infofile, tmp_usersinfo[0], ';');
			std::getline(user_infofile, tmp_usersinfo[1], ';');
			std::getline(user_infofile, tmp_usersinfo[2], ';');
			std::getline(user_infofile, tmp_usersinfo[3], ';');
			std::getline(user_infofile, tmp_usersinfo[4], ';');
			std::getline(user_infofile, tmp_usersinfo[5], ';');
			std::getline(user_infofile, tmp_usersinfo[6], ';');
			std::getline(user_infofile, tmp_usersinfo[7], ';');

			user tmp_userdata(tmp_usersinfo[0], tmp_usersinfo[1], tmp_usersinfo[2], tmp_usersinfo[3],
				tmp_usersinfo[4], tmp_usersinfo[5], tmp_usersinfo[6], tmp_usersinfo[7]);
			tmp_userdata.Data_Corrections();
			this->all_users_base.Add_Users(tmp_userdata);
		}
		user_infofile.close();
	}
}

void FS::main_loop() {

}

void FS::sql_load_data() {

}