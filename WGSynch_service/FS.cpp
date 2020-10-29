#include "FS.h"
using namespace std;

FS::FS() :all_users_base(), main_settings_(), settings_file_path_(".\\settings.ini"s), userfile_check(0){
	main_settings_.init_settings(this->settings_file_path_);
}

FS::FS(const std::string& settings_file_path) : all_users_base(), main_settings_(), settings_file_path_(settings_file_path), userfile_check(0){
	main_settings_.init_settings(this->settings_file_path_);
}

void FS::init_all_users_base() {
	this->all_users_base.Get_Users().clear();
	std::ifstream user_infofile(main_settings_.get_infofile_path(), std::ios::binary);
	std::vector<std::string> tmp_usersinfo(9);
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
			std::getline(user_infofile, tmp_usersinfo[8], '\n');

			int status = 1;
			tmp_usersinfo[8].find("Уволен"s) ? status = 1 : status = 0;

			user tmp_userdata(tmp_usersinfo[0], tmp_usersinfo[1], tmp_usersinfo[2], tmp_usersinfo[3],
				tmp_usersinfo[4], tmp_usersinfo[5], tmp_usersinfo[6], tmp_usersinfo[7], status);
			tmp_userdata.Data_Corrections();

			this->all_users_base.Add_Users(tmp_userdata);
		}
		user_infofile.close();
	} else {
		std::cout << "No USERBASE csv file!"s;
	}
}

void FS::userfile_base_check() {
	size_t ptr = 0;
	if (this->all_users_base.Get_Users()[ptr].Get_Userdata().size() == 10 &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[0] == "NULL"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[1] == "DepartmentName"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[2] == "UserName"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[3] == "Email"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[4] == "WorkTelephone"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[5] == "FIO"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[6] == "Position"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[7] == "SNILS"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[8] == "InterofficeTelephone"s &&
		this->all_users_base.Get_Users()[ptr].Get_Userdata()[9] == "1"s
	) {
		this->userfile_check = 1;
	}
}

void FS::main_loop() {
	this->init_all_users_base();
	this->userfile_base_check();
	if(this->userfile_check){
		std::cout << "Init userfile OK!"s << std::endl;
		this->sql_update_db();
	} else {
		std::cout << "CSV file error"s << std::endl;
	}
	std::cout << "ALL OK!"s << std::endl;
}

