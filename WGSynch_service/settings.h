#pragma once
#include <string>
#include <vector>
#include <algorithm>
#include <fstream>

class settings {
private:
	std::string db_address_;
	std::string db_port_;
	std::string db_name_;
	std::string db_login_;
	std::string db_password_;
	std::string infofile_path_;

public:
	explicit settings();
	explicit settings(const std::string& db_name, const std::string& infofile_path, const std::string& db_address,
		const std::string& db_port, const std::string& login, const std::string& password);


	void init_settings(const std::string& settings_file_path_);

	const std::string get_db_name();
	const std::string get_db_address();
	const size_t get_db_port();
	const std::string get_db_login();
	const std::string get_db_password();
	const std::string get_infofile_path();

	void set_db_name(const std::string& db_name);
	void set_db_address(const std::string& db_address);
	void set_db_port(const std::string& db_port);
	void set_db_login(const std::string& login);
	void set_db_password(const std::string& password);
	void set_infofile_path(const std::string& infofile_path);
};
