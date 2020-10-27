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
	int status_;
public:
	explicit user();
	explicit user(const std::string& Dep, const std::string& Acc, const std::string& Ema, const std::string& Mob,
		const std::string& Name, const std::string& P, const std::string& S, const std::string& Ex, const int stat);

	std::vector<std::string> Get_Userdata() const;
	void Data_Corrections();
};

