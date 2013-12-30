class UsersController < ApplicationController
  include SessionsHelper

  def index
    @user = User.find(current_user)
    @friends = Friend.where(:user_id => current_user)
    @invites = Invite.where(:user_id => current_user)
  end

  def new
  	@user = User.new
  end

  def create
  	@user = User.new(params[:user])
    
    if @user.save
      sign_in @user
      @user = User.find(current_user)
      @friends = Friendship.where(:user_id => current_user, :status_id => 1)
      @invites = Friendship.where(:friend_id => current_user, :status_id => 2)
      @users = User.all
      redirect_to users_path
    else
      render action: "new"
    end
  end

  def show
    @user = User.find(current_user)
    @friends = Friendship.joins(:user).where(:user_id => current_user, :status_id => 1)
  end
end
