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
	this->status_ = 1;
	this->photo_ = "portal.doc/Employees_Photo/photo.jpg"s;
}

user::user(const std::string& Dep, const std::string& Acc, const std::string& Ema, const std::string& Mob,
	const std::string& Name, const std::string& P, const std::string& S, const std::string& Ex, int stat, const std::string& photo)
	:r_uid_("NULL"s), dep_(Dep), account_(Acc), email_(Ema), mobile_(Mob), name_(Name), position_(P), snilz_(S), extel_(Ex),
	status_(stat), photo_(photo) {}

std::vector<std::string> user::Get_Userdata() const {
	std::vector<std::string> tmp__{ this->r_uid_, this->dep_, this->account_, this->email_,  this->mobile_, this->name_,
		this->position_, this->snilz_, this->extel_, std::to_string(this->status_), this->photo_ };
	return tmp__;
}

void user::Data_Corrections() {
	std::replace(this->account_.begin(), this->account_.end(), '\\', '/');
	std::replace(this->dep_.begin(), this->dep_.end(), '\\', '/');
	std::replace(this->name_.begin(), this->name_.end(), '\\', '/');
	std::replace(this->mobile_.begin(), this->mobile_.end(), '\\', '/');
	std::replace(this->position_.begin(), this->position_.end(), '\\', '/');
	std::replace(this->extel_.begin(), this->extel_.end(), '\\', '/');

	std::replace(this->account_.begin(), this->account_.end(), ',', ' ');
	std::replace(this->dep_.begin(), this->dep_.end(), ',', ' ');
	std::replace(this->name_.begin(), this->name_.end(), ',', ' ');
	std::replace(this->mobile_.begin(), this->mobile_.end(), ',', ' ');
	std::replace(this->position_.begin(), this->position_.end(), ',', ' ');
	std::replace(this->extel_.begin(), this->extel_.end(), ',', ' ');
	
	this->dep_.erase(std::remove(this->dep_.begin(), this->dep_.end(), '"'), this->dep_.end());
	this->account_.erase(std::remove(this->account_.begin(), this->account_.end(), '"'), this->account_.end());
	this->email_.erase(std::remove(this->email_.begin(), this->email_.end(), '"'), this->email_.end());
	this->mobile_.erase(std::remove(this->mobile_.begin(), this->mobile_.end(), '"'), this->mobile_.end());
	this->name_.erase(std::remove(this->name_.begin(), this->name_.end(), '"'), this->name_.end());
	this->position_.erase(std::remove(this->position_.begin(), this->position_.end(), '"'), this->position_.end());
	this->snilz_.erase(std::remove(this->snilz_.begin(), this->snilz_.end(), '"'), this->snilz_.end());
	this->extel_.erase(std::remove(this->extel_.begin(), this->extel_.end(), '"'), this->extel_.end());

	this->photo_.erase(std::remove(this->photo_.begin(), this->photo_.end(), '"'), this->photo_.end());
	this->photo_.erase(std::remove(this->photo_.begin(), this->photo_.end(), ';'), this->photo_.end());
	this->photo_.erase(std::remove(this->photo_.begin(), this->photo_.end(), ','), this->photo_.end());
}
