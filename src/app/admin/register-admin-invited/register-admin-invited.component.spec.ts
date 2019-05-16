import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RegisterAdminInvitedComponent } from './register-admin-invited.component';

describe('RegisterAdminInvitedComponent', () => {
  let component: RegisterAdminInvitedComponent;
  let fixture: ComponentFixture<RegisterAdminInvitedComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RegisterAdminInvitedComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RegisterAdminInvitedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
