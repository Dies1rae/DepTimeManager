#include "user.h"


user::user() {
	this->r_uid_ = "NULL";
	this->dep_ = "NULL";
	this->name_ = "NULL";
	this->account_ = "NULL";
	this->email_ = "NULL";
	this->mobile_ = "NULL";
	this->position_ = "NULL";
	this->snilz_ = "NULL";
	this->extel_ = "NULL";
}

std::vector<std::string> user::Get_Userdata() {
	std::vector<std::string> tmp__{ this->r_uid_, this->dep_, this->name_, this->account_, this->email_, this->mobile_,
		this->position_, this->snilz_, this->extel_ };
	return tmp__;
}

void user::Login_Corrections() {
	std::replace_if(this->account_.begin(), this->account_.end(), [](char& A) {return A == '\\';}, '\\\\');
}
