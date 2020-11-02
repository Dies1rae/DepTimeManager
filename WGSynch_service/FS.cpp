#include "FS.h"
using namespace std;

FS::FS(): main_log_container_(NULL), all_users_base(), main_settings_(), settings_file_path_(".\\settings.ini"s), userfile_check(0){
	this->main_settings_.init_settings(this->settings_file_path_);
}

FS::FS(logg* L): main_log_container_(L), all_users_base(), main_settings_(), settings_file_path_(".\\settings.ini"s), userfile_check(0) {
	this->main_log_container_->add_log_string_timemark_("Init SVC settings"s);
	this->main_settings_.init_settings(this->settings_file_path_);
	this->main_log_container_->add_log_string_timemark_("Init SVC settings OK"s);
}

FS::FS(const std::string& settings_file_path): main_log_container_(NULL), all_users_base(), main_settings_(), settings_file_path_(settings_file_path), userfile_check(0){
	this->main_settings_.init_settings(this->settings_file_path_);
}

FS::FS(logg* L, const std::string& settings_file_path): main_log_container_(L), all_users_base(), main_settings_(), settings_file_path_(settings_file_path), userfile_check(0) {
	this->main_log_container_->add_log_string_timemark_("Init SVC settings"s);
	this->main_settings_.init_settings(this->settings_file_path_);
	this->main_log_container_->add_log_string_timemark_("Init SVC settings OK"s);
}

void FS::init_all_users_base() {
	this->all_users_base.Get_Users().clear();
	std::ifstream user_infofile(main_settings_.get_infofile_path(), std::ios::binary);
	std::vector<std::string> tmp_usersinfo(10);
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
			std::getline(user_infofile, tmp_usersinfo[8], ';');
			std::getline(user_infofile, tmp_usersinfo[9], '\n');

			int status = 1;
			if (tmp_usersinfo[8].find("Уволен"s) != std::string::npos) {
				status = 0;
			}

			user tmp_userdata(tmp_usersinfo[0], tmp_usersinfo[1], tmp_usersinfo[2], tmp_usersinfo[3],
				tmp_usersinfo[4], tmp_usersinfo[5], tmp_usersinfo[6], tmp_usersinfo[7], status, tmp_usersinfo[9]);
			tmp_userdata.Data_Corrections();

			/*
			for (auto ptr : tmp_userdata.Get_Userdata()) {
				std::cout << ptr << '&';
			}
			std::cout << std::endl;
			system("PAUSE");*/
			
			this->all_users_base.Add_Users(tmp_userdata);
		}
		user_infofile.close();
	} else {
		this->main_log_container_->add_log_string("No USERBASE csv file!"s);
		this->main_log_container_->add_log_string("CSV file checking error"s);
		this->main_log_container_->add_log_string("");
		this->main_log_container_->add_log_string_timemark_("SVC QUITING status OK"s);
		this->main_log_container_->write_to_file();
	}
}

bool FS::userfile_base_check_exists() {
	std::ifstream user_infofile(main_settings_.get_infofile_path(), std::ios::binary);
	bool ret = !user_infofile.fail();
	user_infofile.close();
	return ret;
}

bool FS::userfile_base_check_fill() {
	if (this->all_users_base.Get_Users()[0].Get_Userdata().size() == 11 &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[0] == "NULL"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[1] == "DepartmentName"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[2] == "UserName"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[3] == "Email"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[4] == "WorkTelephone"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[5] == "FIO"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[6] == "Position"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[7] == "SNILS"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[8] == "InterofficeTelephone"s &&
		this->all_users_base.Get_Users()[0].Get_Userdata()[9] == "1"s 
		//this->all_users_base.Get_Users()[0].Get_Userdata()[10] == "Foto"s
		) {
		return 1;
	}
	return 0;
}

void FS::main_loop() {
	this->userfile_check = userfile_base_check_exists();
	//std::cout << this->userfile_check << std::endl;
	if (this->userfile_check == 0) {
		this->main_log_container_->add_log_string("CSV file checking error"s);
		this->main_log_container_->add_log_string("");
		this->main_log_container_->add_log_string_timemark_("SVC QUITING status OK"s);

		this->main_log_container_->write_to_file();
	}

	if (this->userfile_check == 1){
		this->main_log_container_->add_log_string_timemark_("Init CSV file"s);
		this->init_all_users_base();
		this->main_log_container_->add_log_string_timemark_("Init CSV file OK"s);

		this->main_log_container_->add_log_string_timemark_("Check CSV file consistence"s);
		this->userfile_check = this->userfile_base_check_fill();
		//std::cout << this->userfile_check << std::endl;
		if (this->userfile_check == 1) {

			this->main_log_container_->add_log_string_timemark_("Check CSV file consistence OK"s);
			this->main_log_container_->add_log_string("CSV file checking OK"s);

			this->main_log_container_->add_log_string_timemark_("Init SQL table renew"s);
			this->sql_update_db();
			this->main_log_container_->add_log_string_timemark_("Init SQL table renew OK"s);

		} else {
			this->main_log_container_->add_log_string("CSV file checking error"s);
			this->main_log_container_->add_log_string("");
			this->main_log_container_->add_log_string_timemark_("SVC QUITING status OK"s);

			this->main_log_container_->write_to_file();
		}
	} 

}

