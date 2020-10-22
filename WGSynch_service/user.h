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
	explicit user(const std::string& D, const std::string& N, const std::string& A, const std::string& E,
		const std::string& M, const std::string& P, const std::string& S, const std::string& Ex);

	std::vector<std::string> Get_Userdata() const;
	void Data_Corrections();
};

