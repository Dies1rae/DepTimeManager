#include "settings.h"
using namespace std::string_literals;

settings::settings() = default;
settings::settings(const std::string & db_name, const std::string & infofile_path, const std::string & db_address,
	const std::string & db_port, const std::string & login, const std::string & password):
	db_name_(db_name), infofile_path_(infofile_path), db_address_(db_address), db_port_(db_port),
	db_login_(login), db_password_(password) {}


const std::string settings::get_db_address()  {
	return this->db_address_;
}

const std::string settings::get_db_port() {
	return this->db_port_;
}

const std::string settings::get_db_login() {
	return this->db_login_;
}

const std::string settings::get_db_password() {
	return this->db_password_;
}

const std::string settings::get_infofile_path() {
	return this->infofile_path_;
}
const std::string settings::get_db_name() {
	return this->db_name_;
}

void settings::set_db_address(const std::string& db_address) {
	this->db_address_ = db_address;
}

void settings::set_db_port(const std::string& db_port) {
	this->db_port_ = db_port;
}

void settings::set_db_login(const std::string& login) {
	this->db_login_ =  login;
}

void settings::set_db_password(const std::string& password) {
	this->db_password_ = password;
}

void settings::set_infofile_path(const std::string& infofile_path) {
	this->infofile_path_ = infofile_path;
}

void settings::set_db_name(const std::string& db_name) {
	this->db_name_ = db_name;
}

void settings::init_settings(const std::string& settings_file_path_) {
	std::vector<std::string> settings_string;
	std::ifstream settings_file(settings_file_path_, std::ios::binary);
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
	this->set_db_address(settings_string[0]);
	this->set_db_port(settings_string[1]);
	this->set_db_name(settings_string[2]);
	this->set_db_login(settings_string[3]);
	this->set_db_password(settings_string[4]);
	this->set_infofile_path(settings_string[5]);
}