#include "user.h"
using namespace std::string_literals;

user::user() {
	this->r_uid_ = "NULL"s;
	this->dep_ = "NULL"s;
	this->account_ = "NULL"s;
	this->email_ = "NULL"s;
	this->mobile_ = "NULL"s;
	this->name_ = "NULL"s;
	this->position_ = "NULL"s;
	this->snilz_ = "NULL"s;
	this->extel_ = "NULL"s;
}

user::user(const std::string& D, const std::string& A, const std::string& E, const std::string& M, const std::string& N,
	const std::string& P, const std::string& S, const std::string& Ex)
	:r_uid_("NULL"s), dep_(D), name_(N), account_(A), email_(E), mobile_(M), position_(P), snilz_(S), extel_(Ex) {
};

std::vector<std::string> user::Get_Userdata() const {
	std::vector<std::string> tmp__{ this->r_uid_, this->dep_, this->account_, this->email_,  this->mobile_, this->name_,
		this->position_, this->snilz_, this->extel_ };
	return tmp__;
}

void user::Data_Corrections() {
	std::replace(this->account_.begin(), this->account_.end(), '\\', '/');
	std::replace(this->dep_.begin(), this->dep_.end(), '\\', '/');
	std::replace(this->name_.begin(), this->name_.end(), '\\', '/');
}
