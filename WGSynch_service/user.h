#pragma once
#include <string>
#include <vector>
#include <algorithm>

class user {
private:
	std::string r_uid_;
	std::string dep_;
	std::string name_;
	std::string account_;
	std::string email_;
	std::string mobile_;
	std::string position_;
	std::string snilz_;
	std::string extel_;
public:
	explicit user();
	explicit user(std::string D, std::string N, std::string A, std::string E, std::string M, std::string P, std::string S, std::string Ex)
		:dep_(D), name_(N), account_(A), email_(E), mobile_(M), position_(P), snilz_(S), extel_(Ex) {};
	~user();

	std::vector<std::string> Get_Userdata();
	void Login_Corrections();
};

