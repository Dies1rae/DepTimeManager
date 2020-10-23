#include "settings.h"


settings::settings() = default;
settings::settings(const std::string & db_name, const std::string & infofile_path, const std::string & db_address,
	const std::string & db_port, const std::string & login, const std::string & password):
	db_name_(db_name), infofile_path_(infofile_path), db_address_(db_address), db_port_(db_port),
	db_login_(login), db_password_(password) {}


std::string settings::get_db_address() {
	return this->db_address_;
}

std::string settings::get_db_port() {
	return this->db_port_;
}

std::string settings::get_db_login() {
	return this->db_login_;
}

std::string settings::get_db_password() {
	return this->db_password_;
}

std::string settings::get_infofile_path() {
	return this->infofile_path_;
}
std::string settings::get_db_name() {
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